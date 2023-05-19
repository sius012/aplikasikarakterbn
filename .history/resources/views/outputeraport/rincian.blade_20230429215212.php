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
            <th>Keterangan Aspek</th>
            <th>Keterangan</th>
            <th>Follow Up</th>
        </tr>
        @foreach($rincian as $i => $r)
            <tr>
                <td align="center">{{$i+1}}</td>
                <td align="center">{{$r->siswa->nama_siswa}}</td>
                <td align="center">Berbudi (Tidak Nyolong)</td>
                <td align="center">Nyolong Pisang</td>
                <td align="center">Follow Up</td>
            </tr>
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