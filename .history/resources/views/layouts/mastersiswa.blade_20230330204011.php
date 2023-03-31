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

        .list-siswa .row{
            padding: 30px;
        }

    </style>
    @stack('css')
</head>

<body class="g-sidenav-show  bg-gray-100">
    <div class="container">
        <div class="card">
            <div class="card-header">
                Registrasi Siswa
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="" class="form-label">Masukan NIS</label>
                    <input type="text">
                </div>
            </div>
        </div>
        
    </div>
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
</body>

</html>
