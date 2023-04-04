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
                            @if(isset($jk[$j]))
                                <td class="" data-status="{{$jk[$j]->bookedby_count > 0 ? "booked" : "ready"}}" data-bs-toggle="tooltip" title="Some tooltip text!">
                                    <div class="row">
                                        <div class="col">
                                            Dari
                                            <input type="time" class="form-control bg-info" placeholder="" value="{{$jk[$j]->dari}}" readonly></div>
                                        <div class="col">
                                            Sampai
                                            <input type="time" class="form-control bg-warning" value="{{$jk[$j]->sampai}}" readonly></div>
                                    </div>
                                    </td>
                            @else
                                    <td></td>
                            @endif
                            @endforeach
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning"><i class="fa fa-edit"></i></button>
            </div>
        </div>
    </div>

@endsection