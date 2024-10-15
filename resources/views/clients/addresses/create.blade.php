@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Address for {{ $client->name }}</h1>

        <form method="POST" action="{{ route('clients.addresses.store', $client->id) }}">
            @csrf

            <div class="form-group mb-4">
                <label for="name">Address Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="address">Address</label>
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                    name="address" value="{{ old('address') }}" required>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <a href="{{ route('clients.addresses.index', $client->id) }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
@endsection
