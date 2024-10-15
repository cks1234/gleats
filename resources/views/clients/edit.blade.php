@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Client {{ $client->name }}</h1>

        <form method="POST" action="{{ route('clients.update', $client->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label for="type">Account Type</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type"
                            id="individual" value="individual"
                            {{ old('type', $client->type) == 'individual' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="individual">Individual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type"
                            id="company" value="company" {{ old('type', $client->type) == 'company' ? 'checked' : '' }}
                            required>
                        <label class="form-check-label" for="company">Company</label>
                    </div>
                </div>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $client->name) }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email', $client->email) }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="phone">Phone (Optional)</label>
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                    name="phone" value="{{ old('phone', $client->phone) }}">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="mobile">Mobile</label>
                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                    name="mobile" value="{{ old('mobile', $client->mobile) }}" required>
                @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="postal_address">Postal Address</label>
                <input id="postal_address" type="text" class="form-control @error('postal_address') is-invalid @enderror"
                    name="postal_address" value="{{ old('postal_address', $client->postal_address) }}" required>
                @error('postal_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
