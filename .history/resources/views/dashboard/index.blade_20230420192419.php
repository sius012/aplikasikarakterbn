@extends('layouts.master')
@section('title', 'Smart Dashboard KarakterKuy')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Siswa Kelas 10</h6>
                    <p class="text-sm">
                        <i class="fa fa-arrow-up text-success"></i>
                    </p>
                </div>
                <div class="card-body">
                    <canvas id="kelas-10"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">

            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row" id="container-case">
    </div>
</div>

@endsection

@push("js")
<script>
    function renderCase(caser, element) {
            const ctx = element[0];
            const colors = [
                "rgba(24, 92, 55, 0.7)", // hijau tua
                "rgba(227, 162, 26,0.7)", // kuning tua
                "rgba(194, 24, 91,0.7)", // merah muda tua
            ];
            // Define chart data
            var dataangkatan = [{
                label: 'Kelas ' + caser['kelas']
                , data: caser["data"]["jumlah"]
                , backgroundColor: colors[caser["index"]]
                , borderColor: colors[caser["index"]]
                , borderWidth: 1
            }];


            const chartData = {
                labels: caser["data"]["jurusan"]
                , datasets: dataangkatan
            };

            console.log(dataangkatan);

            // Define chart options
            const chartOptions = {
                responsive: true
                , maintainAspectRatio: false
                , scales: {
                    xAxes: [{
                        stacked: false
                    }]
                    , yAxes: [{
                        stacked: false
                        , ticks: {
                            beginAtZero: true
                            , stepSize: 1
                        }
                    }]
                }
            };

            // Create chart
            const myChart = new Chart(ctx, {
                type: 'bar'
                , data: chartData
                , options: chartOptions
            });
        }

        
    $(document).ready(function() {
        
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $("meta[name=csrf]").attr("content")
            }
            , url: "/dashboard"
            , data: {
                requestJson: "yes"
            }
            , dataType: "json"
            , type: "get"
            , success: function(data) {
                console.log(data);
                for (var i = 0; i < data['statistika'].length; i++) {

                    let classcanvas = "canvas-" + data['statistika'][i]["id_kasus"] + data['statistika'][i]["kelas"];
                    $("#container-case").append(`
                    <div class="col-md-6 p-3">
        <div class="wrapper" style="min-height: 100px">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Data Kasus ${data['statistika'][i]['jeniskasus']}</h6>
                    <p class="text-sm">
                        <i class="fa fa-arrow-up text-success"></i>
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="${classcanvas}"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
                  `);
                    renderCase(data['statistika'][i], $("#" + classcanvas));
                }


            }
            , error: function(err) {
                alert(err.responseText);
            }
        });

        // Get the canvas element and set its width and height
        const canvas = document.getElementById('kelas-10');
        canvas.width = 300;
        canvas.height = 300;

        // Get the context of the canvas element
        const ctx = canvas.getContext('2d');

        // Define the data for the chart
        const data = {
            labels: ['Red', 'Blue', 'Yellow']
            , datasets: [{
                data: [10, 20, 30]
                , backgroundColor: [
                    'rgb(255, 99, 132)'
                    , 'rgb(54, 162, 235)'
                    , 'rgb(255, 205, 86)'
                ]
            }]
        };

        // Create the chart
        const chart = new Chart(ctx, {
            type: 'pie'
            , data: data
        });

    });

</script>

@endpush
