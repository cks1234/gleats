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
                            <td class="d-flex align-items-center gap-1">
                                <a href="{{ route('trc.show', $trc->id) }}" class="btn btn-sm btn-primary">View</a>
                                @if ($trc->status !== 'pending')
                                    <form method="POST" action="{{ route('trc.pending', $trc->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Pending</button>
                                    </form>
                                @endif
                                @if ($trc->status !== 'rejected' && $trc->status !== "signed")
                                    <form class="d-flex align-items-center" method="POST"
                                        action="{{ route('trc.reject', $trc->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                @endif
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
