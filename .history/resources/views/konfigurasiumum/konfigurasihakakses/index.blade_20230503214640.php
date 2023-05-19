@extends("layouts.master")
@section('title', 'Konfigurasi hak akses')
@section('branch1', 'Konfigurasi Umum')
@section('branch2', 'Hak Akses')
@section('content')
<div class="card">
    <div class="card-header py-2">
        <div class="row">
            <div class="col"><h4>Hak Akses</h4></div>
            <div class="col text-end">
                <button class="btn btn-primary m-1">Tambah</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="responsive-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hak Akses</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection