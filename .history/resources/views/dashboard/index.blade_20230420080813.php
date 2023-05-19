@extends('layouts.master')
@section('title', 'Smart Dashboard KarakterKuy')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Top 5 Perilaku Positif Bulan ini</h6>
                </div>
                <div class="col-lg-6 col-5 my-auto text-end">
                  <div class="dropdown float-lg-end pe-4">
                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-ellipsis-v text-secondary"></i>
                    </a>
                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                      <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                      <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                      <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Siswa</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Berkembang Lebih baik</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="avatar-group mt-2">
                          <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                            <img src="../assets/img/team-1.jpg" alt="team1">
                          </a>
                          <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                            <img src="../assets/img/team-2.jpg" alt="team2">
                          </a>
                          <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alexander Smith">
                            <img src="../assets/img/team-3.jpg" alt="team3">
                          </a>
                          <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                            <img src="../assets/img/team-4.jpg" alt="team4">
                          </a>
                        </div>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    </div>
    <div class="col-md-6">
        <div class="wrapper" style="min-height: 100px">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                  <h6>Data Kasus Merokok</h6>
                  <p class="text-sm">
                    <i class="fa fa-arrow-up text-success"></i>
                  </p>
                </div>
                <div class="card-body p-3">
                  <div class="chart">
                    <canvas id="myChart"></canvas>
                  </div>
                </div>
              </div>
           
        </div>
    </div>
</div>
<div class="col-md-6">
  <div class="wrapper" style="min-height: 100px">
      <div class="card z-index-2">
          <div class="card-header pb-0">
            <h6>Data Kasus Merokok</h6>
            <p class="text-sm">
              <i class="fa fa-arrow-up text-success"></i>
            </p>
          </div>
          <div class="card-body p-3">
            <div class="chart">
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
     
  </div>
</div>

<div class="col-8">
  
</div>
</div>

@endsection

@push("js")
<script>
    function()
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
                // Create a chart context
                

            }
        });
    });

</script>

@endpush
