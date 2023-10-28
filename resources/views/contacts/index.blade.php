@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse  ($contacts as $card)
            <a class="text-decoration-none" href="{{ route('contacts.show', $card->id) }}">
                <div id="myDiv" class="d-flex justify-content-between hbg mb-3 rounded px-4 py-2">

                    <div>
                        <img src="/img/logo.png" style="width: 20px">
                    </div>
                    <div class="d-flex align-items-center">
                        <p class="me-2 mb-0">
                            {{ $card->name }}
                        </p>
                        <p href="mailto:{{ $card->email }}" class=".text-reset me-2 mb-0 d-none d-md-block">
                            {{ $card->email }}
                        </p>
                        <p href="tel:{{ $card->phone_number }}" class="me-2 mb-0 d-none d-md-block">
                            {{ $card->phone_number }}
                        </p>
                        <p class="me-2 mb-0 d-none d-md-block">
                            {{ $card->age }}
                        </p>
                    </div>

                </div>
            </a>
        @empty
            <div class="col-md-4 mx-auto">
                <div class="card card-body text center">
                    <p>¡NO HAY NADA!</p>
                    <a href="{{ route('contacts.create') }}">¡METE ALGO!</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
