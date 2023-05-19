@extends('layouts.master')
@section('branch1', 'Profil')
@section('branch2', 'Update Photo Profile')
@section('content')
<div class="container">
    <img src="{{$imagepp}}" alt="Belum Ada Photo Profile">
    <form action="{{route('profile.injectpp')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="">Perbarui Foto Profil</label>
        <input type="file" class="form-control" name="image" required>
        <button class="btn btn-primary mt-3" type="submit">Perbarui</button>
    </form>


    <div class="card">
        <div class="card-header py-2">
            <h4>Hak Akses Saya</h4>
        </div>

    </div>
</div>
@endsection