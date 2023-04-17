@extends('layouts.master')
@section('title', 'Konfigurasi Umum')
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card" style="min-height: 250px">
            <div class="card-body">
                <h4 class="my-3">Konfigurasi Angkatan</h4>
            </div>
            <div class="card-footer">
                <a href="{{route("admin.konfigurasiumum.angkatan")}}"> <button class="btn btn-primary">Masuk</button></a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="min-height: 250px">
            <div class="card-body">
                <h4 class="my-3">Konfigurasi Jurusan</h4>
            </div>
            <div class="card-footer">
                <a href="{{route("admin.konfigurasiumum.jurusan")}}"> <button class="btn btn-primary">Masuk</button></a>
            </div>  
        </div>

    </div>
    <div class="col-md-3">
        <div class="card" style="min-height: 250px">
            <div class="card-body">
                <h4 class="my-3">Konfigurasi Pengguna</h4>
            </div>
            <div class="card-footer">
                <a href="{{route("admin.konfigurasiumum.pengguna")}}"> <button class="btn btn-primary">Masuk</button></a>
            </div>
        </div>

    </div>

    <div class="col-md-3">
        <div class="card" style="min-height: 250px">
            <div class="card-body">
                <h4 class="my-3">Konfigurasi Pengguna</h4>
                
            </div>
            <div class="card-footer">
                <a href="{{route('admin.konfigurasiumum.kategori')}}"> <button class="btn btn-primary">Masuk</button></a>
            </div>
        </div>

    </div>
</div>
@endsection
