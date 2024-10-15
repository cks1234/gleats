@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Addresses of {{ $client->name }}</h1>

        <a href="{{ route('clients.addresses.create', $client->id) }}" class="btn btn-primary mb-3">Add Address</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($addresses->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Address Name</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($addresses as $address)
                        <tr>
                            <td>{{ $address->name }}</td>
                            <td>{{ $address->address }}</td>
                            <td>
                                <a href="{{ route('clients.addresses.edit', [$client->id, $address->id]) }}"
                                    class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('clients.addresses.destroy', [$client->id, $address->id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this address?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No addresses.</p>
        @endif

        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
