<?php

function renderMenu()
{
    $arr =

        [
            [
                "title" => "Dashboard",
                "route" => "dashboard",
                "for" => "Kecuali Murid",
                "icon" => [
                    [
                        "d" => "M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z",
                    ], [
                        "d" => "M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z",
                        "fill-rule" => "evenodd"
                    ]
                ],
                "guard" => "web"
            ],
            [
                "title" => "Beranda",
                "route" => "beranda",
                "for" => "Pamong Putra|Pamong Putri|Admin|Guru BK",
                "icon" =>
                [[
                    "d" => "M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"
                ]],
                "guard" => "web"
            ],
            [
                "title" => "Menu Siswa",
                "route" => "datasiswa",
                "for" => "Kecuali Murid",
                "icon" =>
                [[
                    "d" => "M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"
                ]],
                "guard" => "web"

            ],
            [
                "title" => "Konfigurasi Umum",
                "route" => "admin.konfigurasiumum",
                "for" => "Admin",
                "icon" => [
                    [
                        "d" => "M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86a2.929 2.929 0 0 1 0 5.858z",
                    ]
                ],
                "guard" => "web"
            ],
            [
                "title" => "Konsel Yuk",
                "route" => "siswa.pengajuankonseling",
                "for" => "Siswa",
                "icon" => [
                    [
                        "d" => "M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86a2.929 2.929 0 0 1 0 5.858z",
                    ]
                ],
                "guard" => "siswa"
            ],
            [
                "title" => "Riwayat Konseling",
                "route" => "siswa.riwayatkonseling",
                "for" => "Siswa",
                "icon" => [
                    [
                        "d" => "M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86a2.929 2.929 0 0 1 0 5.858z",
                    ]
                ],
                "guard" => "siswa"
            ],
            [
                "title" => "Reservasi Konseling",
                "route" => "bk.reservasikonseling",
                "for" => "Guru BK",
                "icon" =>
                [[
                    "d" => "M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"
                ]],
                "guard" => "web"
            ],
            [
                "title" => "Jadwal Saya",
                "route" => "bk.jadwalsaya",
                "for" => "Guru BK",
                "icon" =>
                [[
                    "d" => "M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"
                ]],
                "guard" => "web"
            ],
        ];

    return $arr;
}

function renderStatusReservasi($status)
{
    switch ($status) {
        case 'Menunggu':
            return "bg-gradient-info";
            break;
        case 'Selesai':
            return "bg-gradient-success";
            break;
        case 'Ditolak':
            return "bg-gradient-danger";
            break;
        case 'Dibatalkan':
            return "bg-gradient-secondary";
            break;
        default:
            # code...
            break;
    }
}

function rentangtanggal($minggu, $bulan)
{
    $week_num = $minggu;
    $month_num = $bulan;

    $first_day_of_month = date("Y-m-01", strtotime("2023-$month_num-01"));
    $first_day_of_week = date("Y-m-d", strtotime("$first_day_of_month + " . ($week_num - 1) . " weeks"));

    $last_day_of_week = date("Y-m-d", strtotime("$first_day_of_week + 6 days"));

    return ["dari" => $first_day_of_week, "sampai" => $last_day_of_week];
}

function getDayName($date)
{
    $daynames = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
    return $daynames[$date - 1];
}

function hurufDari($angka)
{
    if ($angka >= 3.5 and $angka >= 4) {
        return ["huruf" => "A", "keterangan" => "Membudaya"];
    } else  if ($angka >= 2.5 and $angka <= 3.49) {
        return ["huruf" => "B", "keterangan" => "Berkembang"];
    } else  if ($angka >= 1.5 and $angka <= 2.49) {
        return ["huruf" => "C", "keterangan" => "Mulai Berkembang"];
    } else  if ($angka < 1.5) {
        return ["huruf" => "D", "keterangan" => "Belum Berkembang"];
    }
}

function getDates($d,$m,$y)
{
    $dayOfWeek = 2; // 1 = Monday, 2 = Tuesday, ..., 7 = Sunday
    $weekOfMonth = 1; // 1 = first week, 2 = second week, ..., 5 = last week
    $monthOfYear = 4; // 1 = January, 2 = February, ..., 12 = December

    // Get the first day of the month
    $date = new DateTime();
    $date->setDate(date('Y'), $monthOfYear, 1);

    // Calculate the offset to the desired day of the week
    $offset = ($dayOfWeek - $date->format('N') + 7) % 7;

    // Add the offset to the first day of the month
    $date->add(new DateInterval("P{$offset}D"));

    // Adjust for the week of the month
    $date->add(new DateInterval("P" . ($weekOfMonth - 1) * 7 . "D"));

    // Output the resulting date
    echo $date->format('Y-m-d');
}
