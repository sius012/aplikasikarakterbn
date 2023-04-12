
$(document).ready(function () {
        $('.bootstrap-tagsinput').keyup(function() {
            var kw = $(this).find("input").val();
            $.ajax({
                url: "/listsiswa",
                type: "GET",
                data: {
                    kw: kw
                },
                dataType: 'json',

                success: function(data) {
                    var li = data.map(function(e, i) {
                        return `<li data-nis='${e['nis']}' data-name='${e['nama_siswa']}'>${e['nama_siswa']}</li>`
                    })
                    $('.list-siswa').html(li);

                    
                },
                error: function(err) {
                    alert(err.responseText)
                }
            })
        })
    })