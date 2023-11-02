@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Share Your Contacts Cards</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('card-shares.store') }}" enctype="multipart/form-data">
                            {{-- <form method="POST" action="/card"> --}}
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Destination User Email</label>
                                <div class="col-md-6">
                                    <input id="user_email" type="email"
                                        class="form-control @error('user_email') is-invalid @enderror" name="user_email"
                                        value="{{ old('user_email') }}" autocomplete="user_email">
                                    @error('user_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Sending Card Email</label>
                                <div class="col-md-6">
                                    <input id="card_email" type="email"
                                        class="form-control @error('card_email') is-invalid @enderror" name="card_email"
                                        value="{{ old('card_email') }}" autocomplete="card_email">
                                    @error('card_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
