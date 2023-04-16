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
            <td>Semester:</td>
            <td>Ganjil</td>
        </tr>
        <tr>
            <td>Kelas:</td>
            <td>{{$kelas}}}</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Lengkap Siswa</th>
        </tr>
        @foreach($siswa as $sws)
        <tr>
            <th>No</th>
            <th>Nama Lengkap Siswa</th>
        </tr>
        @endforeach
    </table>
</body>
</html>