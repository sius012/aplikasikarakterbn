@extends('layouts.master')
@section('title', 'Pratinjau Eraport')
@section('content')
<form action="{{route("eraport.send")}}" method="POST">
    @csrf
<div class="form-group">
    <label for="" class="form-label">Kelas</label>
    <input type="number" class="form-control" name="kelas" value="{{$kelas}}" min="10" max="12">
</div>
<div class="form-group">
    <label for="" class="form-label">Jurusan</label>
    <input type="text" class="form-control" name="jurusan" value="{{$jurusan}}">
</div>
<div class="form-group">
    <label for="" class="form-label">Jurusan</label>
    <input type="datetime-local" class="form-control" name="tanggal" value="{{$tanggal}}">
</div>

    <table class="table">
        
        
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>No</td>
            <td>Karakter 4B Nam</td>
            @foreach(reset($aspek)["siswa"] as $i => $sis)
            <td>{{$sis["nama"]}}</td>
            @endforeach
        </tr>

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
            <td>{{$ask["point"]}}</td>
            @foreach($ask["siswa"] as $s => $sw)
            <td></td>
        @endforeach
        </tr>
        @php
            
            $no_point = $row[2];
        @endphp

            
        @endif

        @if($no_subpoint != $row[1])
        <tr>
            <td>{{$row[1]}}</td>
            <td>{{$ask["subpoint"]}}</td>
            @foreach($ask["siswa"] as $s => $sw)
                <td></td>
            @endforeach
        </tr>
        @php
            
            $no_subpoint = $row[1];
        @endphp

            
        @endif
        <tr>
            <td>{{$row[0]}}</td>
            <td>{{$ask["aspek"]}}</td>
            @foreach($ask["siswa"] as $s => $sw)
                <td><input type="text" name="aspek[{{$i}}][{{$s}}]" value="{{$sw["nilai"]}}" class="form-control"></td>
            @endforeach
        </tr>




        @php
        $no ++;
        @endphp
        @endforeach
        <tr>
            <td colspan=2>Keterangan</td>
            @foreach($keterangan as $i => $ktr)
                <td><input type="text" name="ktr[{{$ktr['no']}}]" value="{{$ktr["keterangan"]}}"></td>
            @endforeach   
        </tr>
        <tr>
            <td colspan=2>Follow Up</td>
            @foreach($keterangan as $i => $ktr)
                <td><input type="text" name="fwu[{{$ktr['no']}}]" value="{{$ktr["followup"]}}"></td>
            @endforeach
            
        </tr>
    </table>
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>

@endsection
