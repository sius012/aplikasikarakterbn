@extends('layouts.master')
@section('title', isset($angkatan) ? "Kelas ".$siswa->first()->kelasdanjurusan() : "" )
@section('branch1', 'Data Siswa')
@section('branch1', 'Data Siswa')
@section('previous', isset($angkatan) ? route('datajurusan',["angkatan"=>$siswa->first()->id_angkatan]) : "")
@section('content')
<div class="row">
    @foreach($siswa as $s => $sis)
    <div class="col-md-3 p-3">
        <div class="card" style="width: 18rem;">
            <img src="{{$sis->getImageUrl()}}" class="card-img-top" alt="..." style="object-fit: cover; height: 20rem">
            <div class="card-body">
              <h5 class="card-title">{{$sis->nama_siswa}}</h5>
              <p class="card-text">{{$sis->kelasdanjurusan()}}</p>
              <a href="{{route('profilsiswa', ['nis'=>$sis->nis])}}" class="btn btn-primary">Lihat Detail</a>
            </div>
          </div>
    </div>
    @endforeach

</div>

@endsection
