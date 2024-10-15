@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Jobs</h1>

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
                            <td>{{ ucfirst($job->type) }}</td>
                            <td class="{{ $job->status == 'completed' ? 'text-success' : 'text-warning' }}">
                                {{ ucfirst($job->status) }}</td>
                            <td>
                                <a href="{{ route('jobs.my_jobs_show', $job->id) }}" class="btn btn-sm btn-primary">View</a>

                                @if ($job->status === 'pending')
                                    <a href="{{ route('trc.create', ['job_id' => $job->id]) }}"
                                        class="btn btn-sm btn-info">Generate Test Report</a>
                                @endif

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
