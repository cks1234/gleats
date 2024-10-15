@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Jobs</h1>

        <a href="{{ route('jobs.create') }}" class="btn btn-primary mb-3">Add Job</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($jobs->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Job Number</th>
                        <th>Client</th>
                        <th>Supervisor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $job->job_no }}</td>
                            <td>{{ $job->client->name }}</td>
                            <td class="{{ empty($job->supervisor->name) ? 'text-danger' : 'text-primary' }}">
                                {{ !empty($job->supervisor->name) ? $job->supervisor->name : 'Unassigned' }}
                            </td>
                            <td>{{ ucfirst($job->type) }}</td>
                            <td class="{{ $job->status == 'completed' ? 'text-success' : 'text-warning' }}">
                                {{ ucfirst($job->status) }}</td>
                            <td>
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this job?')">Delete</button>
                                </form>
                                <form action="{{ route('jobs.change_status', $job->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        {{ $job->status === 'pending' ? 'Mark as Completed' : 'Mark as Pending' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No jobs.</p>
        @endif
    </div>
@endsection
