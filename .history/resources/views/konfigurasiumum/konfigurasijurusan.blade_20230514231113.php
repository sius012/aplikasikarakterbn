@extends('layouts.master')
@section('title', 'Konfigurasi Jurusan')
@section('content')
<div class="container">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-jurusan">Tambah Jurusan</button>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Jurusan</th>
                <th>Tampilan Lengkap</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurusan as $j => $jrs)
            <tr>
                <td>{{$j+1}}</td>
                <td>{{$jrs->jurusan}}</td>
                <td>{{$jrs->keterangan}}</td>
                <td><button class="btn btn-warning" value="{{$}}"><i class="fa fa-edit"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" tabindex="-1" id="modal-tambah-jurusan">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.konfigurasiumum.jurusan.tambah')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-label">Jurusan</label>
                        <input name="jurusan" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Keterangan</label>
                        <input name="keterangan" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="modal-edit-jurusan">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.konfigurasiumum.jurusan.edit')}}" method="PUT">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_jurusan">
                    <div class="form-group">
                        <label for="" class="form-label">Jurusan</label>
                        <input name="jurusan" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Keterangan</label>
                        <input name="keterangan" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


$("")
@endsection
