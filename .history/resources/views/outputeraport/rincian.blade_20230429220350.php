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
            <td>Siswa yang mendapatkan nilai satu</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Aspek</th>
            <th>Keterangan</th>
            <th>Follow Up</th>
        </tr>
        @foreach($rincian as $i => $r)
        @foreach($r->aspek_dpg as $j => $adpg)
        <tr>
            @if($j == 0)
            <td align="center" rowspan="{{$r->aspek_dpg->count()}}">{{$i+1}}</td>
            <td align="center" rowspan="{{$r->aspek_dpg->count()}}">{{$r->siswa->nama_siswa}}</td>
            @endif
            <td align="center">{{$r->aspek4B->keterangan}}</td>
            <td align="center">Nyolong Pisang</td>
            <td align="center">Follow Up</td>
        </tr>
        @endforeach
           
        @endforeach
     

        <tr>
            <td>Siswa yang mendapatkan nilai satu (dari catatan asrama)</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Keterangan Aspek</th>
        </tr>
    </table>

    <table>
        
    </table>
</body>
</html>