@extends('layouts.master')
@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-header"    >
            Cari Konselor
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="konselor-searcher">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <img src="https://img.freepik.com/free-photo/senior-man-face-portrait-wearing-bowler-hat_53876-148154.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Alex Moa</h5>
                  <a href="#" class="btn btn-primary">Ajukan Konseling</a>
                </div>
              </div>
        </div>
    </div>
</div>

@push("js")
<script>
    $(document).ready(function(){
        $("#konselor-searcher").keyup(function(){
            var kw = $(this).val();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content")
                },
                url: "{{route('siswa.carikonselor')}}",
                data: {
                    kw: $
                }
            })
        });
    })
</script>
@endpush
@endsection