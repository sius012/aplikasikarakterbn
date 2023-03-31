@extends('layouts.mastersiswa')
@section('content')
<div class="row">
    @foreach($riwayat as $i => $rwt)
    <div class="col-md">
        <div class="card">
            <div class="card-header">
                <h4>{{$rwt->tanggal}}</h4><span class="badge {{renderStatusReservasi($req->status)}}"></span>
            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection
