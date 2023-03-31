@extends('layouts.mastersiswa')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Riwayat Konseling Saya</h3>
    </div>
    <div class="card-body px-0 py-0 m-0" >
        <div class="table-responsive">
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
                            <td><span class="text-secondary text-xs font-weight-bold">{{$rwt->tanggal}}</span></td>
                            <td>{{$rwt->keterangan}}</td>
                            <td class="text-center"><span class="btn badge-sm {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}} </span></td>
                            <td class="text-center">
                                @if($rwt->status == "Menunggu")
                                    <a href=""><button class="btn bg-gradient-danger"><i class="fa fa-trash"></i> Batalkan</button></a>
                                @endif
                            </td>
                        </tr>
                        @if($rwt->catatan_konselor == null)
                        <tr>
                            <th colspan="2">Tanggal Konseling</th>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection