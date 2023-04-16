@extends('layouts.master')
@section('content')
<div class="row"></div>
<input type="text" class="form-control">
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-siswa" type="button" role="tab" aria-controls="nav-home" aria-selected="true">List Siswa</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-rekap" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Rekap</button>
        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-output" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Output</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-siswa" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="card mt-3 mb-4">
            <div class="card-header pb-0">
                <h6>Daftar Siswa Kelas {{$kelas}} {{$jurusan}}</h6>
            </div>
            <div class="card-bodys px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIS</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $s => $sws)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{$sws->getImageUrl()}}" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$sws->nama_siswa}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{$sws->nis}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm @if($sws->jenis_kelamin != "Perempuan") bg-gradient-success @else bg-gradient-danger @endif">{{$sws->jenis_kelamin}}</span>
                                </td>
                            </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-rekap" role="tabpanel" aria-labelledby="nav-profile-tab">@include('outputeraport.eraportkarakter')</div>
    <div class="tab-pane fade" id="nav-output" role="tabpanel" aria-labelledby="nav-contact-tab">@include('eraport.outputeraport')</div>
</div>


@endsection
