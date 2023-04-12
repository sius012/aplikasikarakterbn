@extends('layouts.master')
@section('title', 'Eraport karakter '.$kelas)
@section("content")
<div class="container">
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><a href='{{route("eraport.tambah.manual", ["params"=>$params])}}'>Tambah Eraport</a> </button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-eraport"><i class="fa fa-file-excel"></i></button>
      </div>

    <div class="card">
        <div class="card-header">
            <h6>Daftar Eraport Siswa</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center p-0" id="tes">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eraport as $i => $er)
                        <tr>
                            <td align="center">{{$i+1}}</td>
                            <td>{{$er->tanggal_penilaian}}</td>
                            <td>{{$er->keterangan}}</td>
                            <td>
                                <a href="{{route("eraport.lihat", ["id"=>$er->id_pg])}}"><button class="btn btn-primary"><i class="bi bi-eye"></i></button></a>
                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
</div>


<div class="modal fade" tabindex="-1" id="modal-eraport">
    <div class="modal-dialog">
        <form action="{{route('eraport.validasi')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$params}}" name="param">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eraport Karakter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Masukan Eraport dari data Excel</p>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Tanggal</label>
                        <input name="tanggal" type="datetime-local" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">File Excel</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="" cols="30" rows="2" class="form-control" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </div>
    </div>
    </form>
</div>
@endsection


@push("js")
<script>
    $(document).ready(function() {
        $("#tes").TableKuy({
            tombol: ["pdf"]
        });
    });

</script>

@endpush
