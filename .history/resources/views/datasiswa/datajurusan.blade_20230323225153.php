@extends('layouts.master')
@section('title', 'Data Jurusan')

@section('content')
<div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-siswa">Tambah Siswa</button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-tambah-siswa-excel"><i class="fa fa-file-excel-o"></i></button>
</div>

<div class="row">
    @foreach($jurusan as $i => $jrs)
    <div class="col-md-4">
        @include('components.superApp.cardjurusan')
    </div>
    @endforeach
</div>


<div class="modal fade" tabindex="-1" id="modal-tambah-siswa">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('datajurusan.tambahsiswa')}}" method="POST">
                @csrf
                <input type="hidden" name="id_angkatan" value="{{$angkatan}}" required>
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
                    <div class="form-group mb-3">
                        <label for="jurusan" class="form-label">
                            Jurusan <span style="color: red">*</span>
                        </label>
                        <select name="id_jurusan" id="jurusan" class="form-select" required>
                            @foreach($jurusanall as $i => $jrs)
                            <option value="{{$jrs->id_jurusan}}">{{$jrs->jurusan}} ({{$jrs->keterangan}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin" class="form-label">
                            Alamat
                        </label>
                        <input type="text" class="form-control" name="alamat">
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
@push("js")
<script>

</script>
@endpush
