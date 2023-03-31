@extends('layouts.mastersiswa')
@section('content')
<div class="card">
    <div class="card-header">
        Registrasi Siswa
    </div>
    <form action="{{route("siswa.register.store")}}" method="POST">
        @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="" class="form-label">Masukan NIS</label>
            <input type="number" class="form-control" name="nis" value="{{old("nis")}}">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
    </div>
    
</form>
</div>
@endsection