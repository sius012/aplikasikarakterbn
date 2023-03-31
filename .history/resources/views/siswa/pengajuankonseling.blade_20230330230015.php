@extends('layouts.mastersiswa')
@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-header">
            Cari Konselor
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="konselor-searcher">
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="container-konselor">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('siswa.pengajuankonseling.store')}}" method="POST"
            >
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" class="title-modal">Ajukan Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id-konselor" name="id_konselor">
                <div class="form-group">
                    <label for="" class="form-label">Keterangan</label>
                    <textarea name="keteragan" id="" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Reservasi (Dapat diubah oleh konselor)</label>
                    <input type="datetime-local" name="tanggal" required class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Ajukan Konseling</button>
            </div>
            </form>
        </div>
    </div>
</div>

@push("js")
<script>
    $(document).ready(function() {
        const myModal = new bootstrap.Modal('#exampleModal', {
            keyboard: false
        })
        $("#konselor-searcher").keyup(function() {
            var kw = $(this).val();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content")
                }
                , url: "{{route('siswa.carikonselor')}}"
                , data: {
                    kw: kw
                }
                , type: "get"
                , dataType: "json"
                , success: function(data) {
                    var card = data["konselor"].map(function(e) {
                        return `<div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <img src="https://img.freepik.com/free-photo/senior-man-face-portrait-wearing-bowler-hat_53876-148154.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">${e['name']}</h5>
                  <a href="#" class="btn btn-primary btn-ajukan" data-id="${e['id']}" data-name='${e['name']}'>Ajukan Konseling</a>
                </div>
              </div>
        </div>`
                    });
                    $("#container-konselor").html(card);
                }
                , error: function(err) {
                    alert(err.responseText);
                }
            })
        });

        $(document).delegate(".btn-ajukan","click", function(){
                $("#id-konselor").val($(this).data("id"));
                $("#title-modal").val("Ajukan Konseling dengan "+$(this).data("name"));
                myModal.show();
        });
    })

</script>
@endpush
@endsection
