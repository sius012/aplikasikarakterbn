@extends('master.layouts')
@section('content')
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="card-responsive">
                <table>
                    <thead>
                        <tr>
                            @foreach($variable as $key => $value)
                                
                            @endforeach
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection