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

<div class="modal fade" tabindex="-1" id="modal-tambah-siswa">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('datajurusan.tambahsiswa')}}" method="POST">
                @csrf
                <input type="hidden" name="id_angkatan" value="" required>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="form-label">
                            Nama Lengkap <span style="color: red">*</span>
                        </label>
                        <input type="text" class="form-control" name="nama_siswa" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">
                            NIS <span style="color: red">*</span>
                        </label>
                        <input type="text" class="form-control" name="nis" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">
                            Tempat Lahir <span style="color: red">*</span>
                        </label> <br>
                        <div class="row">
                            <div class="col-4"><input type="text" class="form-control" name="tempat_lahir"></div>
                            <div class="col-8"> <input type="date" class="form-control" name="tanggal_lahir"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="agama" class="form-label">
                            Agama <span style="color: red">*</span>
                        </label>
                        <select name="agama" id="agama" class="form-select" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katholik">Katholik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin" class="form-label">
                            Jenis Kelamin <span style="color: red">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">
                            Angkatan <span style="color: red">*</span>
                        </label>
                        <select name="id_angkatan" id="" class="form-control" required>
                            <option value="">Pilih Angkatan</option>
                            @foreach($angkatanall as $a => $akt)
                            <option value="{{$akt->id_angkatan}}">{{$akt->id_angkatan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jurusan" class="form-label">
                            Jurusan <span style="color: red">*</span>
                        </label>
                        <select name="id_jurusan" id="jurusan" class="form-select" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusan as $i => $jrs)
                            <option value="{{$jrs->id_jurusan}}">{{$jrs->jurusan}} ({{$jrs->keterangan}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label">
                            Alamat
                        </label>
                        <input type="text" class="form-control" name="alamat">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">RT/RW</label>
                       
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="" class="form-lable">Dusun</label>
                            <input type="text" class="form-control" name="dusun">
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Kelurahan</label>
                            <input type="text" class="form-control" name="kelurahan">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="" class="form-lable">Kecamatan</label>
                            <input type="text" class="form-control" name="dusun">
                        </div>
                        <div class="col">
                            <label for="" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" name="kelurahan">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="" class="form-label">No Absen</label>
                        <input type="text" class="form-control" name="no_absen">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal-tambah-siswa-excel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route("datajurusan.tambahsiswa.excel")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa (Excel)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tambahkan data siswa melalui file excel</p>
                    <input type="file" class="form-control" name="file_excel" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
