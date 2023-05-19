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
            <h4>Hak akses saya</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Hak Akses</th>
                            <th>Dari</th>
                            <th>Sampai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hakakses as $i => $ha) 
                        <tr>
                            <td>{{$ha->sebagai}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection