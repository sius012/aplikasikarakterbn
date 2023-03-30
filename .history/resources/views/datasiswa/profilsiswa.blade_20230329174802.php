@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-sm-4">
        <img src="{{asset('https://www.worldphoto.org/sites/default/files/default-media/Piercy.jpg')}}" alt="" class="img-fluid">
    </div>
    <div class="col-sm-8">
        <div class="container">
            <h3>{{$siswa->nama_siswa}}</h3>
            <table class="table">
                <tr>
                    <th>Kelas</th>
                    <td>{{$siswa->kelasdanjurusan()}}</td>
                </tr>
                <tr>
                    <th>Tempat Tanggal Lahir</th>
                    <td>{{$siswa->tempat_lahir}} {{$siswa->tanggal_lahir}}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{$siswa->jenis_kelamin == "P" ? "Perempuan" : "Laki-laki"}}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{$siswa->kelasdanjurusan()}}</td>
                </tr>
            </table>
        </div>
        
    </div>
</div>
@endsection
