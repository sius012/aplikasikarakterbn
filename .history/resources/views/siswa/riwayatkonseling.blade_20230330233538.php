@extends('layouts.mastersiswa')
@section('content')
<div class="row">
    @foreach($riwayat as $i => $rwt)
    <div class="col-md">
        <div class="card">
            <div class="card-header">
                <h4>{{$rwt->tanggal}}<span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span></h4>
            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection
