@extends('layouts.app')

@section('content')
    <div class="container pt-4 p-3">
        <div class="row">
            <h1>Shared with you</h1>
            @forelse  ($contactsSharedWithActualUser as $card)
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
                            <p>Shared by {{ $card->user->email }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4 mx-auto">
                    <div class="card card-body text center">
                        <p>No one shared their cards with you!</p>
                    </div>
                </div>
            @endforelse

            {{ $contactsSharedWithActualUser->links() }}

            <div class="row">
                <h1>Cards You Have Shared</h1>
                @forelse  ($contactsYouHaveShared as $card)
                    @foreach ($card->sharedWithUsers as $user)
                    @endforeach
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
                                <p>Shared to {{ $user->email }}</p>
                                  <form method="POST" action="{{ route('card-shares.destroy', $user->pivot->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mb-2">Unshare Contact</button>
                            </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-4 mx-auto">
                        <div class="card card-body text center">
                            <p>You have not shared any cards yet!</p>
                        </div>
                    </div>
                @endforelse
                {{-- {{ $contactsYouHaveShared->links() }} --}}
            </div>
        </div>
    @endsection
