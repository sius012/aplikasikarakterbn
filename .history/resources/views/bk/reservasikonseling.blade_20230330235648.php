@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Reservasi Konseling</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Dibuat pada</th>
                        <th>{{$req->created_at}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection