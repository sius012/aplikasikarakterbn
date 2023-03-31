@extends('layouts.master')
@section('title', 'Rekap Eraport')
@section('content')
<div class="container">
    @foreach($rekapbulan as $i => $re)

    <div class="card m-2">
        <div class="row">
            <div class="col">
                <div class="card-body">
                    <p class="fw-bold">{{$re["judul"]}}</p>
                    <div class="row">
                        <div class="col">
                            <p>Penilai Sekolah: {{$re["pg"]["sekolah"]["jumlah"]}}</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col">
                <div class="card-body">
                    <a href="{{route("eraport.rekaperaportdetail", ['params'=>$re['params']])}}"><button class="btn btn-primary my-auto"><i class="fa fa-info"></i></button></a>
                </div>
            </div>
        </div>
    </div>

    @endforeach

</div>
@endsection
