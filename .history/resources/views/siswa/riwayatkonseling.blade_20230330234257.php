@extends('layouts.mastersiswa')
@section('content')
<div class="row">
    @foreach($riwayat as $i => $rwt)
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col ">
                        <h5>Konseling tanggal {{$rwt->tanggal}}</h5>
                    </div>
                    <div class="col justify-content-end">
                        <span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span>
                    </div>
                </div>
                
            </div>
            <div class="card-body py-0">
                <p><b>Konselor:</b> {{$rwt->konselor->name}}</p>
                <p>{{$rwt->keterangan}}</p>
            </div>
            <div class="card-footer py-1">
                <button class="btn  bg-gradient-danger"><i class="fa fa-trash"></i>Batalkan</button>
            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection
