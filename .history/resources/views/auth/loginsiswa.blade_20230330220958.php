@extends('layouts.mastersiswa')
@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h3>Masuk</h3>
    </div>
    <form action="{{route("siswa.login.attempt")}}" method="POST">
        @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="" class="form-label">NIS</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
    </div>
    <div class="card-header">
        <button class="btn bg-gradient-primary" type="submit" >
            Masuk
        </button>
    </div>
</form>
</div>

@push("js")
@if()
@endsection