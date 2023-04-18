@extends('master.layouts')
@section('branch1', 'Profil')
@section('branch2', 'Update Photo Profile')
@section('content')
<div class="container">
    <img src="{{Auth::user()->getPhotoProfile()}}" alt="Belum Ada Photo Profile">
    <form action="{{route('profile.injectpp')}}">
        @csrf
        <label for="">Perbarui Foto Profil</label>
        <input type="file" class="form-control" name="pp">
        <button class="btn btn-primary"></button>
    </form>
</div>
@endsection