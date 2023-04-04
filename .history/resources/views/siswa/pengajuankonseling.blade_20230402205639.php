@extends('layouts.mastersiswa')
@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-header">
            Cari Konselor
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="konselor-searcher">
                </div>
            </div>
            <div class="row">
                @foreach($konselor as $ks)
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{asset('/images/profile.png')}}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">{{$ks["user"]->name}}</h5>
                              <p class="card-text">Jadwal Tersedia(Minggu Ini) : <span class="badge bg-success">{{$ks['jadwal_minggu_ini']}} Sesi</span></p>
                            </div>
                            <div class="card-footer">
                                <button class="btn bg-gradient-primary"></button>
                            </div>
                          </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row" id="container-konselor">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('siswa.pengajuankonseling.store')}}" method="POST"
            >
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" class="title-modal">Ajukan Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id-konselor" name="id_konselor">
                <div class="form-group">
                    <label for="" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Reservasi (Dapat diubah oleh konselor)</label>
                    <input type="datetime-local" name="tanggal" required class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Ajukan Konseling</button>
            </div>
            </form>
        </div>
    </div>
</div>

@push("js")
@endpush
@endsection
