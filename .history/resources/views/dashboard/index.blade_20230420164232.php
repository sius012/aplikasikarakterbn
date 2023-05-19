@extends('layouts.master')
@section('title', 'Smart Dashboard KarakterKuy')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h3></h3>
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
    </div>
</div>
<div class="row" id="container-case">
</div>

@endsection

@push("js")
<script>
    $(document).ready(function() {
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
                            beginAtZero: true,
                            stepSize: 1
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

                for (var i = 0; i < data.length; i++) {
                    let classcanvas = "canvas-" + data[i]["id_kasus"]+ data[i]["kelas"];
                    $("#container-case").append(`
                    <div class="col-md-6 p-3">
        <div class="wrapper" style="min-height: 100px">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Data Kasus ${data[i]['jeniskasus']}</h6>
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
                    renderCase(data[i], $("#" + classcanvas));
                }


            }
            , error: function(err) {
                alert(err.responseText);
            }
        });
    });

</script>

@endpush
