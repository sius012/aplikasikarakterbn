@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="card-responsive">
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
                                <td>isset($jk[$j]) ?  $jk[$j]->dari : "Kosong"}} <a href=""><i></i></a></td>
                            @endforeach
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection