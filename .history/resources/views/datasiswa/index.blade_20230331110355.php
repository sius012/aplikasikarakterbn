@extends('layouts.master')
@section('title', 'DataSiswa')

@section('content')

<div class="container ">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
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