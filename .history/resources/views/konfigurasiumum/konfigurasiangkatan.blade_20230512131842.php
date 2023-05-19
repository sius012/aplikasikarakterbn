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
                <td><button class="btn btn-warning btn-edit-angkatan" value="{{$akt->id_angkatan}}"><i class="bi bi-pencil"></i></button></td>
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

<div class="modal" tabindex="-1" id='modal-edit-jurusan'>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Jurusan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('admin.konfigurasiumum.angkatan.edit')}}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Angkatan</h5>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@push("js")
<script>
    $(document).ready(function(){
        var modalEdit = new B
        $(".btn-edit-angkatan").click(function(){
            $.ajax({
                url : "/getangkatan",
                type : "get",
                data: {
                    id: $(this).val()
                },
                dataType: "json",
                success: function(data){
                    
                }
            })
        })
    })
</script>

@endpush
