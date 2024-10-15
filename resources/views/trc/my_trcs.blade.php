@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Test Report Certificates</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($trcs->count() > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Job Number</th>
                        <th>Supervisor</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trcs as $trc)
                        <tr>
                            <td>{{ $trc->job->job_no }}</td>
                            <td>{{ $trc->job->supervisor->name }}</td>
                            <td
                                class="{{ $trc->status == 'signed' ? 'text-success' : ($trc->status == 'pending' ? 'text-warning' : 'text-danger') }}">
                                {{ ucfirst($trc->status) }}</td>
                            <td>
                                <a href="{{ route('trc.my_trc_show', $trc->id) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No test reports.</p>
        @endif
    </div>
@endsection
