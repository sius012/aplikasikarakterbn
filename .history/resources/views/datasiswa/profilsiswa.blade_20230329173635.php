@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <img src="{{asset('https://www.worldphoto.org/sites/default/files/default-media/Piercy.jpg')}}" alt="" class="img-fluid">
    </div>
    <div class="col-sm-6">
        <div class="container">
            <h3>{{$siswa->nama_siswa}}</h3>
            <table>
                <tr>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
