@extends('layouts.master')
@section('content')
<form action="{{route('injectsiswa.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" class="form-control" name="file" required>
    <input type="submit" class="btn btn-primary">
</form>
@endsection