@extends('layouts.app')

@section('content')
    <div class="col-md-4 mx-auto">
        <div class="card card-body text center">
            <p>Your free trial has expired.</p>
            {{-- <p>Purchase a membership.</p> --}}
            <a href="{{ route('sub-checkout') }}">Purchase a membership.</a>
        </div>
    </div>
@endsection
