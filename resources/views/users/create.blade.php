@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add User</h1>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="form-group mb-4">
                <label for="name">Name</label>
                <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="email">Email</label>
                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                    name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="password">Password</label>
                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password"
                    name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                    type="password" name="password_confirmation" required>
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="phone">Phone (Optional)</label>
                <input id="phone" class="form-control @error('phone') is-invalid @enderror" type="text"
                    name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="mobile">Mobile</label>
                <input id="mobile" class="form-control @error('mobile') is-invalid @enderror" type="text"
                    name="mobile" value="{{ old('mobile') }}" required>
                @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="address">Address</label>
                <input id="address" class="form-control @error('address') is-invalid @enderror" type="text"
                    name="address" value="{{ old('address') }}" required>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="role">Role</label>
                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                    <option value="">Select Role</option>
                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="contractor" {{ old('role') == 'contractor' ? 'selected' : '' }}>Contractor</option>
                    <option value="tradesperson" {{ old('role') == 'tradesperson' ? 'selected' : '' }}>Tradesperson
                    </option>
                    <option value="labourer" {{ old('role') == 'labourer' ? 'selected' : '' }}>Labourer</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
@endsection
