@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Job Details</h1>

        @if ($job->status === 'pending')
            <div class="mb-3">
                <a href="{{ route('trc.create', ['job_id' => $job->id]) }}" class="btn btn-sm btn-info">Generate Test
                    Report</a>
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
                        <span class="{{ $job->status == 'completed' ? 'text-success' : 'text-warning' }}">
                            {{ ucfirst($job->status) }}
                        </span>
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

        <a href="{{ route('jobs.my_jobs', $job->supervisor) }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
