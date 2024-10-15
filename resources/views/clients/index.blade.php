@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Clients</h1>

        <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Add Client</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($clients->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Mobile</th>
                        <th>Postal Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ ucfirst($client->type) }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ !empty($client->phone) ? $client->phone : '-' }}</td>
                            <td>{{ $client->mobile }}</td>
                            <td>{{ $client->postal_address }}</td>
                            <td>
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this client?')">Delete</button>
                                </form>

                                <a href="{{ route('clients.addresses.index', $client->id) }}"
                                    class="btn btn-sm btn-primary">Addresses</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No clients.</p>
        @endif
    </div>
@endsection
