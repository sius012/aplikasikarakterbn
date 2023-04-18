@extends('master.layouts')
@section('branch1', 'Profil')
@section('branch2', 'Update Photo Profile')
@section('content')
<div class="container">
    <img src="{{Auth::user()->getPhotoProfile()}}" alt="Belum Ada Photo Profile">
    <form action="{{route('profile.injectpp')}}">
        @csrf
        <input type="file" class="form-control">
    </form>
</div>
@endsection