<!--
=========================================================
* Soft UI Dashboard - v1.0.7
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('ui-assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('ui-assets/img/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>
        @yield("title")
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{asset('ui-assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('ui-assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <script src="{{asset('js/app.js')}}"></script>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script>
        const getDateFromString = str => {
            const [date, time] = str.split(" ");
            // reformat string into YYYY-MM-DDTHH:mm:ss.sssZ
            str = `${date}T${time}.000Z`
            let dat = new Date(str);
            return dat.toISOString().slice(0, 10);
        };

    </script>
    <link href="{{asset('ui-assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('ui-assets/css/soft-ui-dashboard.css')}}" rel="stylesheet" />
    <style>
        .custom-tooltip {
            background: rgba(0, 0, 0, 0.3);
            position: absolute;
            color: white;
            padding: 10px;
            border-radius: 10px;
            z-index: 3;
            width: 200px;
        }

        .indicator {
            width: 10px;
            height: 10px;
        }




        .red {
            background: red;
        }

        .row-tooltip < div {
            display: inline;
        }

        .list-siswa {
            min-width: 100px;
            padding: 10px;
        }

        .list-siswa .row {
            padding: 30px;
        }

        .border-booked {
            border: 4px solid rgb(103, 209, 174);
            border-radius: 20px
        }

        .card-info {
            display: inline;
            padding: 5px;
        }

        .card-info h5 {
            font-size: 10pt;
            margin: 0px;
        }

        .session-card {
            padding: 20px;
            border-radius: 30px;
        }

        .booked {
            border: 2px solid rgb(110, 110, 110);
        }

        .done {
            border: 2px solid rgb(93, 234, 192);
        }

    </style>
    @stack('css')
</head>

<body class="g-sidenav-show  bg-gray-100">
    @include('sweetalert::alert')
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html " target="_blank">
                <img src="{{asset('ui-assets/img/logo-ct-dark.png')}}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">KarakterKuy</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">

            <ul class="navbar-nav">
                @php
                $currenturl = "";
                @endphp
                @foreach(renderMenu() as $i => $nav)

                @php
                $active


                @endphp

                @auth($nav["guard"])
                @if(in_array(Auth::user()->getRoleNames()->first(),explode("|", $nav["for"])) or $nav["for"] == "Kecuali Murid")
                <li class="nav-item">
                    <a class="nav-link  @if(route($nav['route']) == url()->current())active @elseif(in_array(Route::currentRouteName(),$nav['groupedRoute'])) active @endif" href="{{route($nav['route'])}}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" fill-rule="evenodd" class="bi bi-people-fill" viewBox="0 0 16 16">
                                @if(isset($nav["icon"]))
                                @foreach($nav["icon"] as $j => $nv)
                                <path class="color-background   " d="{{$nv['d']}}" @if(isset($nv['file-rule'])) file-rule="{{$nv['file-rule']}}" @endif></path>
                                @endforeach
                                @endif
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">{{$nav['title']}}</span>
                    </a>
                </li>
                @endif
                @endauth
                @endforeach

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Lainnya</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="../pages/profile.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>customer-support</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(1.000000, 0.000000)">
                                                <path class="color-background opacity-6" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"></path>
                                                <path class="color-background" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                                                <path class="color-background" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">@yield("branch1")</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield("branch2")</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">@yield('title')</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            @if(Auth::check())
                            <a href="{{route('logout')}}" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Logout</span>
                            </a>
                            @endif
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0 ">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0 ">
                                                    <i class="fa fa-clock me-1"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0 ">
                                                    <i class="fa fa-clock me-1"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4" style="min-height: 80vh !important">
            @yield("content")


        </div>
        <footer class="footer pt-3  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>
                                document.write(new Date().getFullYear())

                            </script>,
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    @yield('outer')
    <!--   Core JS Files   -->
    <script src="{{asset('ui-assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('ui-assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('ui-assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('ui-assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('ui-assets/js/plugins/chartjs.min.js')}}"></script>
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar"
            , data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                , datasets: [{
                    label: "Sales"
                    , tension: 0.4
                    , borderWidth: 0
                    , borderRadius: 4
                    , borderSkipped: false
                    , backgroundColor: "#fff"
                    , data: [450, 200, 100, 220, 500, 100, 400, 230, 500]
                    , maxBarThickness: 6
                }, ]
            , }
            , options: {
                responsive: true
                , maintainAspectRatio: false
                , plugins: {
                    legend: {
                        display: false
                    , }
                }
                , interaction: {
                    intersect: false
                    , mode: 'index'
                , }
                , scales: {
                    y: {
                        grid: {
                            drawBorder: false
                            , display: false
                            , drawOnChartArea: false
                            , drawTicks: false
                        , }
                        , ticks: {
                            suggestedMin: 0
                            , suggestedMax: 500
                            , beginAtZero: true
                            , padding: 15
                            , font: {
                                size: 14
                                , family: "Open Sans"
                                , style: 'normal'
                                , lineHeight: 2
                            }
                            , color: "#fff"
                        }
                    , }
                    , x: {
                        grid: {
                            drawBorder: false
                            , display: false
                            , drawOnChartArea: false
                            , drawTicks: false
                        }
                        , ticks: {
                            display: false
                        }
                    , }
                , }
            , }
        , });

        var ctx2 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

        var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

        new Chart(ctx2, {
            type: "bar"
            , data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                , datasets: [{
                        label: "Mobile apps"
                        , tension: 0.4
                        , borderWidth: 0
                        , pointRadius: 0
                        , borderColor: "#cb0c9f"
                        , borderWidth: 3
                        , backgroundColor: gradientStroke1
                        , fill: true
                        , data: [50, 40, 300, 220, 500, 250, 400, 230, 500]
                        , maxBarThickness: 6

                    }
                    , {
                        label: "Websites"
                        , tension: 0.4
                        , borderWidth: 0
                        , pointRadius: 0
                        , borderColor: "#3A416F"
                        , borderWidth: 3
                        , backgroundColor: gradientStroke2
                        , fill: true
                        , data: [30, 90, 40, 140, 290, 290, 340, 230, 400]
                        , maxBarThickness: 6
                    }
                , ]
            , }
            , options: {
                responsive: true
                , maintainAspectRatio: false
                , plugins: {
                    legend: {
                        display: false
                    , }
                }
                , interaction: {
                    intersect: false
                    , mode: 'index'
                , }
                , scales: {
                    y: {
                        grid: {
                            drawBorder: false
                            , display: true
                            , drawOnChartArea: true
                            , drawTicks: false
                            , borderDash: [5, 5]
                        }
                        , ticks: {
                            display: true
                            , padding: 10
                            , color: '#b2b9bf'
                            , font: {
                                size: 11
                                , family: "Open Sans"
                                , style: 'normal'
                                , lineHeight: 2
                            }
                        , }
                    }
                    , x: {
                        grid: {
                            drawBorder: false
                            , display: false
                            , drawOnChartArea: false
                            , drawTicks: false
                            , borderDash: [5, 5]
                        }
                        , ticks: {
                            display: true
                            , color: '#b2b9bf'
                            , padding: 20
                            , font: {
                                size: 11
                                , family: "Open Sans"
                                , style: 'normal'
                                , lineHeight: 2
                            }
                        , }
                    }
                , }
            , }
        , });

    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('ui-assets/js/soft-ui-dashboard.min.js?v=1.0.7')}}"></script>
    <script src="{{asset("js/custom-tooltips.js")}}"></script>
    @stack('js')


    @if(in_array("Guru BK",Auth::user()->getRoleNames()->toArray()))
    <script>
        if (Notification.permission == "granted") {
            
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                alert("terimakasih :)");
            })
        }

        window.Echo.channel("pesanreservasi."+"{{Auth::user()->id}}").listen("BuatReservasi", (event) => {
            if (Notification.permission == "granted") {
                
                var notif = new Notification("Konseling Masuk", {
                    body: e.message;
                    , icon: "{{asset('siswa/10/RPL/2_10_1011342_.jpg')}}"
                , });
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    alert('tes');
                })
            }
        });

    </script>
    @endif
</body>

</html>
