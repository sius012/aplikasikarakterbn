@extends('layouts.master')
@push("css")
<style>
    .custom-tooltip{
        background: rgba(0, 0, 0, 0.3);
        position: absolute;
        color: white;
        padding: 10px;
        border-radius: 10px;
        z-index: 3;
        width: 150px
    }

    .indicator{
        width: 10px;
        height: 10px;
    }

    .red {
        background: red;
    }

    .row-tooltip < div{
        display: inline;
    }
</style>

@endpush
@section('content')
    <table class="table">
        <thead>
           
        </thead>
        <tbody></tbody>
    </table>
@endsection