<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>Siswa yang mendapatkan nilai satu</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Aspek</th>
            <th>Keterangan</th>
            <th>Follow Up</th>
        </tr>
        @foreach($rincian['sekolah'] as $i => $r)
        @foreach($r->aspek_dpg as $j => $adpg)
        <tr>
            @if($j == 0)
            <td align="center" rowspan="{{$r->aspek_dpg->count()}}">{{$i+1}}</td>
            <td align="center" rowspan="{{$r->aspek_dpg->count()}}">{{$r->siswa->nama_siswa}}</td>
            @endif
            <td align="center">{{$adpg->aspek4B->keterangan}}</td>
            @if($j == 0)
            <td align="center">{{$r->keterangan}}</td>
            <td align="center">{{$r->followup}}</td>
            @endif
            
        </tr>
        @endforeach
           
        @endforeach
     

        <tr>
            <th>Siswa yang mendapatkan nilai satu (dari catatan asrama)</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Keterangan</th>
        </tr>
        @foreach($rincian['asrama'] as $i => $ra)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$ra->siswa->nama_siswa}}</td>
            </tr>
        @endforeach
    </table>

    <table>
        
    </table>
</body>
</html>