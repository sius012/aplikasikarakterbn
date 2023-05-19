<?php

use App\Models\User;
use App\Models\TeacherHasTeaching;

function renderMenu()
{
    $arr =

        [
            [
                "title" => "Dashboard",
                "route" => "dashboard",
                "for" => "Kecuali Murid",
                "groupedRoute" => [],
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
                "for" => "Pamong Putra|Pamong Putri|Admin|Guru BK|Kepala Sekolah|Kesiswaan",
                "icon" =>
                [[
                    "d" => "M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"
                ]],
                "groupedRoute" => [],
                "guard" => "web"
            ],
            [
                "title" => "Menu Siswa",
                "route" => "datasiswa",
                "groupedRoute" => ["bk.lihatjadwal", "datajurusan"],
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
                "for" => "Admin|Guru BK",
                "groupedRoute"=>[],
                "icon" => [
                    [
                        "d" => "M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86a2.929 2.929 0 0 1 0 5.858z",
                    ]
                ],
                "guard" => "web"
            ],
            [
                "title" => "Laporan Harian",
                "route" => "laporan_harian",
                "for" => "Pamong Putra|Pamong Putri",
                "groupedRoute"=>[],
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
                "groupedRoute" => [],
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
                "groupedRoute"=>[],
                "icon" => [
                    [
                        "d" => "M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86a2.929 2.929 0 0 1 0 5.858z",
                    ]
                ],
                "guard" => "siswa"
            ],
            [
                "title" => "Raport Karakter",
                "route" => "eraport.raportkarakter",
                "groupedRoute" => [],
                "for" => "Admin|Guru BK",
                "icon" =>
                [[
                    "d" => "M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"
                ]],
                "guard" => "web"
            ],
            [
                "title" => "Profil Saya",
                "route" => "siswa.profilsaya",
                "groupedRoute" => [],
                "for" => "Admin|Guru BK",
                "icon" =>
                [[
                    "d" => "M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z",
                ],[
                    "d"=> "M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z",
                ],[
                    "d"=>"M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"
                ]],
                "guard" => "siswa"
            ],
            [
                "title" => "Riwayat Reservasi",
                "route" => "bk.reservasikonseling",
                "groupedRoute" => [],
                "for" => "Guru BK|Admin|Konselor",
                "icon" =>
                [[
                    "d" => "M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z",
                ],[
                    "d"=>"M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"
                ]],
                "guard" => "web"
            ],
            [
                "title" => "Reservasi Konseling",
                "route" => "bk.jadwalsaya",
                "groupedRoute" => ["profil.lihatjadwal"],
                "for" => "Guru BK|Admin|Konselor",
                "icon" =>
                [[
                    "d" => "M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"
                ]],
                "guard" => "web"
            ],
            [
                "title" => "Hak Akses Saya",
                "route" => "hakaksessaya",
                "groupedRoute" => [],
                "for" => "Guru",
                "icon" =>
                [[
                    "d" => "M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"
                ]],
                "guard" => "web"
            ],
            
        ];

    return $arr;
}

function renderStatusReservasi($status)
{
    switch ($status) {
        case 'Dipesan':
            return "bg-gradient-secondary";
            break;
        case 'Selesai':
            return "bg-gradient-success";
            break;
        case 'Ditolak':
            return "bg-gradient-danger";
            break;
        case 'Reschedule':
            return "bg-gradient-warning";
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

function getDates($d,$w,$m, $y, $type=null)
{
    $days = [
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
        "Minggu"
    ];
    $dayOfWeek = $d; // 1 = Monday, 2 = Tuesday, ..., 7 = Sunday
    $weekOfMonth = $w; // 1 = first week, 2 = second week, ..., 5 = last week
    $monthOfYear = $m; // 1 = January, 2 = February, ..., 12 = December
    $year = $y;

    // Get the first day of the month
    $date = new DateTime();
    $date->setDate($year, $monthOfYear, 1);

    // Calculate the offset to the desired day of the week
    $offset = ($dayOfWeek - $date->format('N') + 7) % 7;

    // Add the offset to the first day of the month
    $date->add(new DateInterval("P{$offset}D"));

    // Adjust for the week of the month
    $date->add(new DateInterval("P" . ($weekOfMonth - 1) * 7 . "D"));

    // Output the resulting date
    if($type!=null){
        if($type=="hari"){
            return $days[$d-1];
        }
    }
    return $date->format('Y-m-d');
}

function bulans(){
    return 
    [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
}

function convertToExcelColumn($num)
{
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return convertToExcelColumn($num2) . $letter;
    } else {
        return $letter;
    }
}

function regularPermission($arr1,$arr2){
    $visibity = false;
    foreach($arr1 as $a){
        foreach($arr2 as $b){
            if($a == $b){
                $visibity = true;
            }
        }
    }
    return $visibity;
}


function checkClassPermission($arr){
    //isi array
    //1. auth = Berisi data user yg sedang login
    //2. angkatan 
    //3. jurusan 
    //4. 
    $auth = $arr["auth"];
    $angkatan = $arr["angkatan"];
    $jurusan = $arr["jurusan"];

    $permission = TeacherHasTeaching::where("id_angkatan",$angkatan)->where("id_jurusan",$jurusan)->where("sebagai", "LIKE","%Wali Kelas%")->where("sampai", ">", date("Y-m-d"))->get()->count();
    $visibility = false;
    $regularpermission = regularPermission($auth->user()->getRoleNames(),["Guru BK","Admin","Kepala Sekolah","Kesiswaan","Pamong Putra","Pamong Putri"]);

    if($regularpermission){
               
        $visibility = true;
     }else if($permission > 0){
         $visibility = true;
     }
    
     return $visibility;

    
}

function roman_to_decimal($roman_numeral)
{
    $romans = array("M" => 1000, "CM" => 900, "D" => 500, "CD" => 400, "C" => 100, "XC" => 90, "L" => 50, "XL" => 40, "X" => 10, "IX" => 9, "V" => 5, "IV" => 4, "I" => 1);
    $decimal = 0;
    foreach ($romans as $key => $value) {
        while (strpos($roman_numeral, $key) === 0) {
            $decimal += $value;
            $roman_numeral = substr($roman_numeral, strlen($key));
        }
    }
    return $decimal;
}


function hasNumber($str)
{
    $isThereNumber = false;
    for ($i = 0; $i < strlen($str); $i++) {
        if (ctype_digit($str[$i])) {
            $isThereNumber = true;

            return $isThereNumber;
            break;
        }
    }
}



function renderRole($roles){
    $string = "(";
    foreach($roles->toArray() as $i => $rol){
        $string .= $rol;
        if(isset($roles->toArray()[$i+1])){
            $string.=", ";
        }
    }
    $string.=")";
    return $string;
}


  /**
 * Function kie fungsinipun kangge ngebuka form utawa larik;
 *
 * @param string $method kangge nentukake methode.
 * @param string $method kangge ngisi atribute utawa param.
 */
function bukaLarik($method, array $params){
    $form = "<form method='".$method."' ";
    foreach($params as $i => $p){
        $form .= ' '.$i."="."'".$p."'";
    }
    $form .= ">";

    return $form;
}

function form