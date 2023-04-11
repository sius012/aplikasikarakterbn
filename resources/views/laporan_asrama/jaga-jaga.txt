<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
    body {
        background: rgba(243 244 246);
        overflow: hidden;
        font-family: sans-serif;
    }

    .foto_posting {
        margin-top: 80px;
        margin-left: 5px;
        height: 30em;
        width: 40em;
        transition: 0.3s;
        border-radius: 10px;
        border: 2px solid black;
    }


    

    .posting .file {
        display: none;
    }



    .konten {
        margin-left: 45em;
        margin-top: -30em;
        width: 50%;
    }

    .konten textarea {
        width: 98%;
    }

    .konten .tags {
        width: 90%;
    }

    .label-info {
        background: rgb(54, 53, 53);
        border-radius: 10%;
        padding: 10px;
        text-align: center;
    }

    span{
    margin: 4px;
 }

 .tag {
  background-color: #3f51b5;
  color: white;
  padding: 5px;
  border-radius: 5px;
  margin-right: 5px;
  margin-bottom: 5px;
  display: inline-block;
}

.siswa{
    padding: 10px;
    width: 99%;
}

.siswa option{
    padding: 20em;
}

.simpan{
    padding: 7px;
    color: white;
    border-radius: 12%;
    border: none;
    width: 10%;
    background-color:rgb(44 37 133);
}

.simpan:hover{
    background-color: rgb(102 95 181);
}

.fa-chevron-left{
    position: relative;
    margin-top: -18em;
    margin-left: 10px;
    font-size: 27px;
    background: white;
    padding: 1em;
    border-radius: 5px;
}

.fa-chevron-right{
     position: relative;
    margin-top: -11em;
    margin-left: 20em;
    font-size: 27px;
    background: white;
    padding: 1em;
    border-radius: 5px;
    transition: 0.5s;
}

.fa-chevron-right:hover{
    background: rgb(146, 149, 148);
    color: white;
}

</style>


@php
    $gambarss = $data->gambar;

    $gambar_array = explode('|',$gambarss);

    unset($gambar_array[1]);

    $gambar_baru = implode("|", $gambar_array);
@endphp

<body>
    <label class="posting">
        
        <img id="gambar" class="foto_posting"
            src="{{asset('postingan/'.$gambar_baru)}}"> 
       
    </label>

    <div><a style="cursor: pointer" onclick="next()"><i class="fa fa-chevron-right"></i></a></div>

    <div class="konten">
        <form action="/tambah_siswa" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" name="idnya" value="{{$data->id_laporan}}">
            <textarea name="deskripsi" placeholder="Tambahkan Deskripsi Anda..." name="deskripsi" id="" class="form-control" cols="30" rows="10"></textarea><br><br>

            
                <div class="tag-input">
                <input type="text" id="tag-input-field" class="form-control siswa" placeholder="Tambahkan Nama Siswa" list="siswa-list" autocomplete="off"> <br>
                <div class="tag-container"></div>
                <input type="hidden" name="tags" id="tags-input" value="">

                <datalist id="siswa-list">
                    @foreach($murid as $m)
                        <option value="{{$m->nama_siswa}}">
                    @endforeach
                </datalist>
                </div>



            <a href="/kembali/{{$data->id_laporan}}" type="submit" class="btn btn-primary">Kembali</a>
            <button class="simpan">Simpan</button>

        </form>
        <div>

            

</body>


<script>
    $(document).ready(function() {
    var tags = [];

    $('#tag-input-field').keydown(function(event) {
        var tagInput = $(this).val();
        if (event.keyCode === 13 || event.keyCode === 188) { 
        event.preventDefault();
        if (tagInput.length > 0) {
            addTag(tagInput);
            $(this).val('');
        }
        }
    });

  function addTag(tagInput) {
    var tag = $('<span class="tag">' + tagInput + '<span style="cursor: pointer" class="remove-tag">&times;</span></span>');
    $('.tag-container').append(tag);
    tags.push(tagInput);
    $('#tags-input').val(tags.join(','));
  }

  $(document).on('click', '.remove-tag', function() {
    var tag = $(this).parent('.tag');
    var tagIndex = $('.tag').index(tag);
    tags.splice(tagIndex, 1);
    tag.remove();
    $('#tags-input').val(tags.join(','));
  });
});




var daftarGambar = "{{$data->gambar}}";
var gambarArray = daftarGambar.split("|");

var i = 0;
var gambar = document.getElementById("gambar");
gambar.src = gambarArray[0];



function next(){
    if(i == gambarArray.length - 1){
        i=0;
    }else{
        i++;
    }
    gambar.src = gambarArray[i];
}
console.log(gambarArray)
</script>


