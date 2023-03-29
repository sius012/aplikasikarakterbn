<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            border-collapse: collapse;
        }
        td,th{
            border: 1px solid black;
            font-size: 8pt;
        }

        input{
            height: 30px;
            margin: 0px;
            width: 95%;
            border: none;
        }

        table{
            width: 2000px;
        }
    </style>
</head>
<body>
    <h3>Penilaian Raport Karakter SMK BAGIMU NEGERIKU</h3>
    <form action="{{route("eraport.update")}}" method="POST">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="">Tanggal</label>
            <input type="datetime-local" value="{{$tanggal}}" name="tanggal">
        </div>
        <table class="table">
            <thead>
            <tr>
                <th style="width: 10px">No</th>
                <th >Karakter 4B Nama</th>
                @foreach(reset($aspek)["siswa"] as $i => $sis)
                <th style="width: 10px">{{$sis["nama"]}}</th>
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
                <td>{{$row[2]}}</td>
                <td>{{$ask["point"]}}</td>
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
                <td>{{$row[1]}}</td>
                <td style="width: 100px">{{$ask["subpoint"]}}</td>
                @foreach($ask["siswa"] as $s => $sw)
                    <td ></td>
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
                    <td ><input type="text" name="adpg[{{$sw['id_adpg']}}]" value="{{$sw["nilai"]}}" class="form-control"></td>
                @endforeach
            </tr>
    
    
    
    
            @php
            $no ++;
            @endphp
            @endforeach
            <tr>
                <td colspan=2 >Keterangan</td>
                @foreach($keterangan as $i => $ktr)
                    <td><input type="text" name="ktr[{{$ktr["id_dpg"]}}]" value="{{$ktr["keterangan"]}}"></td>
                @endforeach   
            </tr>
            <tr>
                <td colspan=2>Follow Up</td>
                @foreach($keterangan as $i => $ktr)
                    <td > <input type="text" name="fwu[{{$ktr['id_dpg']}}]" value="{{$ktr["followup"]}}"></td>
                @endforeach
                
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    
</body>
</html>
