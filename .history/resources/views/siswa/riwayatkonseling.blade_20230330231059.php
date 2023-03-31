@extends('layouts.mastersiswa')
@section('content')
<div class="card">
    <div class="card-header">
        Riwayat Konseling Saya
    </div>
    <div class="card-body px-0 py-0 m-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $i => $rwt)
                        <tr>
                            <td>{{$rwt->}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection