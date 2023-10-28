@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Contact</div>

                    <div class="card-body">
                        <p>Name: {{ $card->name }}</p>
                        <p>Phone Number: <a class="text-info"
                                href="tel:{{ $card->phone_number }}">{{ $card->phone_number }}</a></p>
                        <p>Email: <a class="text-info"
                                href="mailto:{{ $card->email }}">{{ $card->email }}</a></p>
                        <p>Age: {{ $card->age }}</p>
                        <p>Created at:{{ $card->created_at }}</p>
                        <p>Updated at:{{ $card->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
