@extends('layouts.master')
@section('branch1', 'Menu Siswa')
@section('branch2', 'Kelas')
@section('title', 'Data Jurusan')

@section('content')


<div class="row">
    @foreach($jurusan as $i => $jrs)
    @php
        $visibility = $jrs["visibility"];
        $jrs = $jrs['data'];   
@endphp
    <div class="col-md-4">
        @include('components.superApp.cardjurusan')
    </div>
    @endforeach
</div>



@endsection
@push("js")
<script>

</script>
@endpush
