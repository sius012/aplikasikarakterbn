<div class="row mb-4">
    <div class="container card">
        <div class="row m-3">
            <div class="col-md-1">
                <img class="rounded-circle shadow" src="{{$cs->penilai->getPhotoProfile()}}" alt="" style="height: 80px; width: 80px; object-fit: cover">
            </div>
            <div class="col">
                <b>{{$cs->penilai->name}} menambahkan Catatan untuk {{$cs->siswa->nama_siswa}}</b>
                <p>{{$cs->tanggal}}</p>
            </div>
        </div>

        <div class="row">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home{{$i}}" type="button" role="tab" aria-controls="home" aria-selected="true">Keterangan</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home{{$i}}" type="button" role="tab" aria-controls="home" aria-selected="true">Keterangan</button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active p-3" id="home{{$i}}" role="tabpanel" aria-labelledby="home-tab"> <p>{{$cs->keterangan}}</p>

                    <div class="container">
                        @if($cs->lampiran != null)
                        <img src="{{asset("lampiran/".$cs->lampiran->nama_file)}}" alt="" style="width: 200px">
                        @endif
                    </div></div>
                <div class="tab-pane fade" id="profile{{$i}}" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="card">
                    <div class="card-header pb-0 px-3">
                      <h6 class="mb-0">Billing Information</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                      <ul class="list-group">
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                          <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Oliver Liam</h6>
                            <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Viking Burrito</span></span>
                            <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                            <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                          </div>
                          <div class="ms-auto text-end">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                          </div>
                        </li>
                        <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                          <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Lucas Harper</h6>
                            <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Stone Tech Zone</span></span>
                            <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">lucas@stone-tech.com</span></span>
                            <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                          </div>
                          <div class="ms-auto text-end">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                          </div>
                        </li>
                        <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                          <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Ethan James</h6>
                            <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Fiber Notion</span></span>
                            <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">ethan@fiber.com</span></span>
                            <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                          </div>
                          <div class="ms-auto text-end">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                </div>
                <div class="tab-pane fade" id="contact{{$i}}" role="tabpanel" aria-labelledby="contact-tab">...</div>
              </div>

           
        </div>
    </div>