@extends('layouts.master')
@section('title', 'Konfigurasi Angkatan')
@section('content')
<div class="container">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-angkatan">Tambah Angkatan</button>
    <table class="table ">
        <thead>
            <tr>
                <th>No</th>
                <th>Angkatan</th>
                <th>Tahun Mulai</th>
                <th>Tahun Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($angkatan as $a => $akt)
            <tr>
                <td>{{$a+1}}</td>
                <td>{{$akt->id_angkatan}}</td>
                <td>{{$akt->tahun_mulai}}</td>
                <td>{{$akt->tahun_selesai}}</td>
                <td><button class="btn btn-warning btn-edit-angkatan" value="{{$akt->id_angkatan}}"><i class="bi bi-pencil"></i></button>
                    @if($akt->siswa_count > 1)<button class="btn btn-danger btn-hps-angkatan" value="{{$akt->id_angkatan}}"><i class="fa fa-trash"></i></button>@endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="modal-tambah-angkatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.konfigurasiumum.angkatan.tambah')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Angkatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Angkatan</label>
                        <input type="number" min="1" class="form-control" name="angkatan" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Tahun Masuk</label>
                        <input type="date" class="form-control" name="tahun_mulai" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Tahun Selesai</label>
                        <input type="date" class="form-control" name="tahun_selesai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id='modal-edit-angkatan'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Angkatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.konfigurasiumum.angkatan.edit')}}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <input type="hidden" min="1" class="form-control" name="angkatan1" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Tahun Masuk</label>
                        <input type="date" class="form-control" name="tahun_mulai" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="" class="form-label">Tahun Selesai</label>
                        <input type="date" class="form-control" name="tahun_selesai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push("js")
<script>
    $(document).ready(function() {
        var modalEdit = new bootstrap.Modal($("#modal-edit-angkatan"), {
            keyboard: false
        });
        $(".btn-edit-angkatan").click(function() {
            $.ajax({
                url: "/getangkatan"
                , type: "get"
                , data: {
                    id: $(this).val()
                }
                , dataType: "json"
                , success: function(data) {
                    $("#modal-edit-angkatan").find("input[name=angkatan1]").val(data['id_angkatan']);
                    $("#modal-edit-angkatan").find("input[name=tahun_mulai]").val(data['tahun_mulai']);
                    $("#modal-edit-angkatan").find("input[name=tahun_selesai]").val(data['tahun_selesai']);
                    modalEdit.show();
                }
            })
        })

        $(".btn-hps-angkatan").click(function() {
            let val = $(this).val();
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus angkatan?'
                , showCancelButton: true
                , confirmButtonText: 'Hapus'

            , }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN" : $("meta[name=csrf-token]").attr("content")
                        },
                        url: "/hapusangkatan",
                        type: "post",
                        data: {
                            id: val
                        },
                        success: function(){
                            Swal.fire("Data berhasil dihapus")
                        },error: function(err){
                            alert(err.responseText)
                        }
                        
                    })
                } 
            })
        });
    })

</script>

@endpush
