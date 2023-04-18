@extends('master.layouts')
@section('branch1', 'Profil')
@section('branch2', 'Update Photo Profile')
@section('content')
<div class="container">
    <img src="{{getPhotoProfile(){}}" alt="">
</div>
@endsection