@extends('layouts.authsiswa')
@section('content')
<div class="card  mt-5">
    <div class="card-header">
       <h3>Registrasi Siswa</h3> 
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
        <div class="form-group">
            Sudah mengaktifkan akun? 
        </div>
    </div>
    <div class="card-header">
        <button class="btn bg-gradient-primary" type="submit" >
            Buka Akun
        </button>
    </div>
</form>
</div>
@endsection