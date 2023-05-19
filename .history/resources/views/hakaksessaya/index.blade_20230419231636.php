@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h4>Hak Akses Saya</h4>
                </div>
                <div class="col text-end">
                    <button class="btn-primary"></button>
                </div>
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Hak Akses</th>
                            <th>Dari</th>
                            <th>Sampai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hakakses as $i => $ha) 
                        <tr>
                            <td>{{$ha->sebagai}}</td>
                            <td>{{$ha->dari}}</td>
                            <td>{{$ha->sampai}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection