@extends('master.layouts')
@section('content')
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="card-responsive">
                <table>
                    <thead>
                        <tr>
                            @foreach($jadwalkonseling["detail"] as $i=> $jk)
                                <td>{{$jk}}</td>
                            @endforeach
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection