@extends('layouts.mastersiswa')
@section('title', 'Riwayat Konseling Saya')
@section('content')

    @foreach($riwayat as $i => $rwt)
    <div class="row mb-3">
    <div class="col-md">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm">
                        <h5>Konseling tanggal {{$rwt->tanggal}}</h5>
                    </div>
                    <div class="col-sm justify-content-end">
                        <span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span>
                    </div>
                </div>
                
            </div>
            <div class="card-body py-0">
                <p><b>Konselor:</b> {{$rwt->detailjk->jadwal}}</p>
                <p>{{$rwt->keterangan}}</p>
            </div>
            @if($rwt->status == "Menunggu")
            <div class="card-footer py-1">
                <button class="btn  bg-gradient-danger"><i class="fa fa-trash"></i>Batalkan</button>
            </div>
            @endif
        </div>
    </div>
</div>
    @endforeach



@endsection
