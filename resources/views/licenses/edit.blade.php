@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit License of {{ $license->user->name }}</h1>

        <form method="POST" action="{{ route('licenses.update', $license->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label for="type">License Type</label>
                <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type"
                    value="{{ old('type', $license->type) }}" required>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="license">License Number</label>
                <input id="license" type="text" class="form-control @error('license') is-invalid @enderror"
                    name="license" value="{{ old('license', $license->license) }}" required>
                @error('license')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="expiry">License Expiry Date</label>
                <input id="expiry" type="date" class="form-control @error('expiry') is-invalid @enderror"
                    name="expiry" value="{{ old('expiry', $license->expiry ? $license->expiry->format('Y-m-d') : null) }}"
                    required>
                @error('expiry')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <a href="{{ route('licenses.index', $license->user->id) }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
