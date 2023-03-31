@extends('layouts.mastersiswa')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Riwayat Konseling Saya</h3>
    </div>
    <div class="card-body px-0 py-0 m-0" >
        <div class="table-responsive" style="min-height: 100vh">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $i => $rwt)
                        <tr>
                            <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-8">Tanggal Catatan</th>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection