@extends('layouts.app')

@section('content')
    <div class="container pt-4 p-3">
        <div class="row">
            <h1>Recently Added</h1>
            @forelse  ($contacts as $card)
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('contacts.show', $card->id) }}">
                                    <img class="profile_pic mb-2" src="{{ Storage::url($card->profile_picture) }}">
                                </a>
                            </div>
                            <a class="text-decoration-none text-white" href="{{ route('contacts.show', $card->id) }}">
                                <h3 class="card-title text-capitalize">{{ $card->name }}</h3>
                            </a>
                            <p class="m-2">{{ $card->phone_number }}</p>

                            <a href="{{ route('contacts.edit', $card->id) }}" class="btn btn-secondary mb-2">Edit
                                Contact</a>

                            <form method="POST" action="{{ route('contacts.destroy', $card->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mb-2">Delete Contact</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4 mx-auto">
                    <div class="card card-body text center">
                        <p>¡NO HAY NADA!</p>
                        <a href="{{ route('contacts.create') }}">¡METE ALGO!</a>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
@endsection
