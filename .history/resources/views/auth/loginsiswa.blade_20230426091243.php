@extends('layouts.authsiswa')
@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h3>Masuk</h3>
    </div>
    <form action="{{route("siswa.login.attempt")}}" method="POST">
        @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="" class="form-label">NIS</label>
            <input type="number" class="form-control" name="nis">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="form-group">
        Bulum Mengaktifkan akun? <p><a href="{{route('regis')}}">Aktifkan</a></p>
        </div>
    </div>
    <div class="card-header">
        <button class="btn bg-gradient-primary" type="submit" >
            Masuk
        </button>
    </div>
</form>
</div>

@push("js")
@if(Session::has("error"))
    <script>
        alert("{{Session::get('error')}}")
    </script>
@endif
@endpush
@endsection