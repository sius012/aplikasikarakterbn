<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nama Siswa</title>
</head>
<body>
    <table>
        <tr>
            <td>Semester:</td>
            <td>Ganjil</td>
        </tr>
        <tr>
            <td>Kelas:</td>
            <td>{{$kelas}}/{{$jurusan}}</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Lengkap Siswa</th>
        </tr>
        @foreach($siswa as $sws)
        <tr>
            <th>{{$sws->no_absen}}</th>
            <th>{{$sws->nama_siswa}}</th>
        </tr>
        @endforeach
    </table>
</body>
</html>