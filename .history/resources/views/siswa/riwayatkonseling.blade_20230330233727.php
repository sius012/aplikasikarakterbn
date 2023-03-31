@extends('layouts.mastersiswa')
@section('content')
<div class="row">
    @foreach($riwayat as $i => $rwt)
    <div class="col-md">
        <div class="card">
            <div class="card-header">
                <h5>{{$rwt->tanggal}}</h5><span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span>
            </div>
            <div class="card-body">
                <p>{{$rwt->keterangan}}</p>
            </div>
            <div class="card-footer">
                <button class="btn  btn-danger"><i class=""></i></button>
            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection
