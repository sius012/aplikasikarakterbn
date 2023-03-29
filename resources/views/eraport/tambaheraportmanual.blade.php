@extends('layouts.master')
@section('title', 'Penilaian Eraport Karakter kelas '.$kelas)
@push('css')
<style>
    input {
        display: flex;
        margin: 0px;
        width: 95%;
        border: none;
    }

    td,
    th {
        height: 50px;
        padding: 0px;
    }

</style>
@endpush
@section('content')

<form action="{{route("eraport.tambahmanual.store")}}" method="POST">
    @csrf
    <input type="hidden" required name='params' value="{{$params}}">
    <div class="form-group">
        <label for="">Tanggal</label>
        <input type="datetime-local" name="tanggal" value="{{Carbon\Carbon::now()->toDatetimeString()}}" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="">Keterangan</label>
        <input type="text" name="keterangan" class="form-control" required>
    </div>
    <div class="container-fluid">
        <div class="containers d-flex" style="width: 1000px; ">
            <div class="containers" style=" overflow-x:scroll">
                <table class="table table-striped" style="width: 10px !imporant;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 10px">Aspek</th>
                        </tr>
                    </thead>

                    @php
                    $no = 0;
                    $no_subpoint = "";
                    $no_point = "";
                    @endphp
                    @foreach($aspek as $i => $ask)
                    @php
                    $row = explode(":",$i);

                    @endphp
                    @if($no_point != $row[2])
                    <tr>
                        <td>{{$row[2]}}</td>
                        <td style="width: 1000px">{{$ask["point"]}}</td>

                    </tr>
                    @php

                    $no_point = $row[2];
                    @endphp

                    @endif

                    @if($no_subpoint != $row[1])
                    <tr>
                        <td>{{$row[1]}}</td>
                        <td style="width: 100px">{{$ask["subpoint"]}}</td>
                    </tr>
                    @php

                    $no_subpoint = $row[1];
                    @endphp

                    @endif
                    <tr>
                        <td>{{$row[0]}}</td>
                        <td>{{$ask["aspek"]}}</td>
                    </tr>

                    @php
                    $no ++;
                    @endphp
                    @endforeach
                    <tr>
                        <td></td>
                        <td style="width: 10px">Keterangan</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 10px">Follow Up</td>
                    </tr>
                </table>
            </div>

            <div class="containers" style="max-width: 50vw; overflow-x:scroll">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @foreach(reset($aspek)["siswa"] as $i => $sis)
                            <th style="width: 10px">{{$sis->nama_siswa}}</th>
                            @endforeach
                        </tr>
                    </thead>

                    @php
                    $no = 0;
                    $no_subpoint = "";
                    $no_point = "";
                    @endphp
                    @foreach($aspek as $i => $ask)
                    @php
                    $row = explode(":",$i);

                    @endphp
                    @if($no_point != $row[2])
                    <tr>
                        @foreach($ask["siswa"] as $s => $sw)
                        <td style="width: 10px"></td>
                        @endforeach
                    </tr>
                    @php

                    $no_point = $row[2];
                    @endphp

                    @endif

                    @if($no_subpoint != $row[1])
                    <tr>
                        @foreach($ask["siswa"] as $s => $sw)
                        <td></td>
                        @endforeach
                    </tr>
                    @php

                    $no_subpoint = $row[1];
                    @endphp

                    @endif
                    <tr>
                        @foreach($ask["siswa"] as $s => $sw)
                        <td><input type="number" name='dpg[{{$sw->nis}}][{{$ask['id_aspek']}}]' min="1" max="4" value="3" required></td>
                        @endforeach
                    </tr>

                    @php
                    $no ++;
                    @endphp
                    @endforeach
                    <tr>
                        @foreach(reset($aspek)["siswa"] as $s => $sw)
                        <td><input type="text" name='ktr[{{$sw->nis}}]' ></td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach(reset($aspek)["siswa"] as $s => $sw)
                        <td><input type="text" name='fwu[{{$sw->nis}}]' ></td>
                        @endforeach
                    </tr>
                </table>
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
@endsection
