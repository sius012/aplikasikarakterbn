@extends('layouts.master')
@section('branch1', 'Menu Siswa')

@section('title', 'DataSiswa')

@section('content')

<div class="container ">
    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-siswa">Tambah Siswa</button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-tambah-siswa-excel"><i class="fa fa-file-excel-o"></i></button>
    </div>
    <div class="card mb-3">
        <form action="{{route('carisiswa')}}" method="GET">
        <div class="card-header pb-2">
            <h5>Filter</h5>
        </div>
        <div class="card-body pt-0">
            <div class="row mb-3">
                <div class="col-6">
                    <input type="text" placeholder="Nama Siswa" class="form-control" name="nama">
                </div>
                <div class="col-3">
                    <select name="angkatan" id="" class="form-select">
                        <option value="">Angkatan</option>
                        @foreach($angkatan as $akt)
                            <option value="{{$akt->id_angkatan}}">{{$akt->id_angkatan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select name="jurusan" id="" class="form-select">
                        <option value="">Jurusan</option>
                        @foreach($jurusan as $jrs)
                            <option value="{{$jrs->id_jurusan}}">{{$jrs->jurusan}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row py-0">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </div>
    </form>
    </div>
    <div class="row justify-content-md-center">
        @foreach($kelas as $i => $kls)
        <div class="col-md-4">
            @php
                $jumlahsiswa = $kls["jumlahsiswa"];
                $labelkelas = $i;
                $angkatan = $kls["angkatan"];
            @endphp

            @include('components.superApp.cardkelas')
        </div>
        @endforeach
    </div>

</div>



@endsection
