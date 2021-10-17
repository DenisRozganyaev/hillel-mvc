@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="text-center">{{ __('Admin Dashboard') }}</h3>
            </div>
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
