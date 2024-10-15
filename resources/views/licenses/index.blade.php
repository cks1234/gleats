@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Licenses of {{ $user->name }}</h1>

        <a href="{{ route('licenses.create', $user->id) }}" class="btn btn-primary mb-3">Add License</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($licenses->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>License Type</th>
                        <th>License Number</th>
                        <th>License Expiry</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($licenses as $license)
                        <tr>
                            <td>{{ $license->type }}</td>
                            <td>{{ $license->license }}</td>
                            <td>{{ $license->expiry->format('d M Y') }}</td>
                            <td>{{ $license->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('licenses.edit', $license->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('licenses.destroy', $license->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this license?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No licenses.</p>
        @endif
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
