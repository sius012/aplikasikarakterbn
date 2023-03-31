@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Reservasi Konseling</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Dibuat pada</th>
                        <th>Waktu Konseling</th>
                        <th>Keterangan Siswa</th>
                        <th>Status</th>
                        <th>Catatan Konselor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservasikonseling as $rk)
                        <tr>
                            <td>{{$rk->created_at}}</td>
                            <td>{{$rk->tanggal}}</td>
                            <td>{{$rk->keterangan}}</td>
                            <td><span class="badge {{renderStatusReservasi($rk->status)}}">{{$rk->status}}</span></td>
                            <td>@if($rk->catatan_konselor != null) $rk->catatan_konselor @else Belum ditanggapi @endif</td>
                            <td>
                                <button class="btn btn-"></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection