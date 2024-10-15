@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Job Details</h1>

        <div class="mb-3">
            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"
                    onclick="return confirm('Are you sure you want to delete this job?')">Delete</button>
            </form>
            <form action="{{ route('jobs.change_status', $job->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm btn-success">
                    {{ $job->status === 'pending' ? 'Mark as Completed' : 'Mark as Pending' }}
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h4>Job Information</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Job Number</h5>
                        <p>{{ $job->job_no }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Status</h5>
                        <p class="{{ $job->status == 'completed' ? 'text-success' : 'text-warning' }}">
                            {{ ucfirst($job->status) }}
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Client</h5>
                        <p>{{ $job->client->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Assigned Supervisor</h5>
                        <p class="{{ empty($job->supervisor->name) ? 'text-danger' : 'text-primary' }}">
                            {{ !empty($job->supervisor->name) ? $job->supervisor->name : 'Unassigned' }}
                        </p>
                    </div>
                </div>

                @if ($job->supervisor && $job->license)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Supervisor's License Type</h5>
                            <p>{{ $job->license->type }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Supervisor's License Number</h5>
                            <p>{{ $job->license->license }}</p>
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Job Type</h5>
                        <p>{{ ucfirst($job->type) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Work Address</h5>
                        <p>{{ $job->address->name }} - {{ $job->address->address }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Description</h5>
                        <p>{{ !empty($job->description) ? $job->description : '-' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5>Created At</h5>
                        <p>{{ $job->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Updated At</h5>
                        <p>{{ $job->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Client Information</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Type</h5>
                        <p>{{ ucfirst($job->client->type) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Email</h5>
                        <p>{{ $job->client->email }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Phone</h5>
                        <p>{{ !empty($job->client->phone) ? $job->client->phone : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Mobile</h5>
                        <p>{{ $job->client->mobile }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Postal Address</h5>
                        <p>{{ $job->client->postal_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
