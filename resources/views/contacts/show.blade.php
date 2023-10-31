@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Contact</div>

                    <div class="card-body">
                        <p class="d-flex justify-content-center">
                            <img class="profile_pic mb-2" src="{{ Storage::url($card->profile_picture) }}">
                        </p>
                        <p class="d-flex justify-content-center">Name: {{ $card->name }}</p>
                        <p class="d-flex justify-content-center">Phone Number: <a class="text-info"
                                href="tel:{{ $card->phone_number }}">{{ $card->phone_number }}</a></p>
                        <p class="d-flex justify-content-center">Email: <a class="text-info" href="mailto:{{ $card->email }}">{{ $card->email }}</a></p>
                        <p class="d-flex justify-content-center">Age: {{ $card->age }}</p>
                        <p class="d-flex justify-content-center">Created at:{{ $card->created_at }}</p>
                        <p class="d-flex justify-content-center">Updated at:{{ $card->updated_at }}</p>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('contacts.edit', $card->id) }}" class="btn btn-secondary mb-2 mx-1">Edit
                                Contact</a>

                        <form method="POST" action="{{ route('contacts.destroy', $card->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mb-2 mx-1">Delete Contact</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
