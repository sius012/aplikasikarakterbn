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
                <th>Bulan Mulai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($angkatan as $a => $akt)
            <tr>
                <td>{{$a+1}}</td>
                <td>{{$akt->id_angkatan}}</td>
                <td>{{$akt->tahun_mulai}}</td>
                <td>{{$akt->bulan_mulai}}</td>
                <td><button class="btn btn-warning"><i class="bi bi-pencil"></i></button></td>
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
                    <input type="number" class="form-control" name="tahun_mulai" required>
                </div>
                <div class="mb-3 form-group">
                    <label for="" class="form-label">Bulan Masuk</label>
                    <input type="number" class="form-control" name="bulan_mulai" required>
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
@endsection
