@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add License for {{ $user->name }}</h1>

        <form method="POST" action="{{ route('licenses.store', $user->id) }}">
            @csrf

            <div class="form-group mb-4">
                <label for="type">License Type</label>
                <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type"
                    value="{{ old('type') }}" required>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="license">License Number</label>
                <input id="license" type="text" class="form-control @error('license') is-invalid @enderror"
                    name="license" value="{{ old('license') }}" required>
                @error('license')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="expiry">License Expiry</label>
                <input id="expiry" type="date" class="form-control @error('expiry') is-invalid @enderror"
                    name="expiry" value="{{ old('expiry') }}" required>
                @error('expiry')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <a href="{{ route('licenses.index', $user->id) }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
@endsection
