@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            @foreach($jadwalkonseling["detail"] as $i=> $jk)
                                <td>{{$i}}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @for($j = 0;$j < 5;$j++)
                        <tr>
                            @foreach($jadwalkonseling["detail"] as $k => $jk)
                                <td class="">@if(isset($jk[$j]))
                                    <div class="row">
                                        <div class="col">
                                            Dari
                                            <input type="time" class="form-control mb-3 bg-" placeholder=""></div>
                                        <div class="col">
                                            Sampai
                                            <input type="time" class="form-control"></div>
                                    </div>
                                     @endif</td>
                            @endforeach
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection