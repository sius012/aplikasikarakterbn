@extends('layouts.mastersiswa')
@section('content')
<div class="card">
    <div class="card-header">
        Registrasi Siswa
    </div>
    <form action="{{route()}}"></form>
    <div class="card-body">
        <div class="form-group">
            <label for="" class="form-label">Masukan NIS</label>
            <input type="number" class="form-control">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Password</label>
            <input type="password" class="form-control" name="">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" name="password">
        </div>
    </div>
</div>
@endsection