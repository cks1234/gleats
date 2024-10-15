@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Licenses</h1>

        @if ($licenses->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>License Type</th>
                        <th>License Number</th>
                        <th>License Expiry</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($licenses as $license)
                        <tr>
                            <td>{{ $license->type }}</td>
                            <td>{{ $license->license }}</td>
                            <td>{{ $license->expiry->format('d M Y') }}</td>
                            <td>{{ $license->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No licenses.</p>
        @endif
    </div>
@endsection
