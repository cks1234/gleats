@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Test Report for Job #{{ $job->job_no }}</h1>
        <livewire:test-report-certificate :job_id="$job->id" />

    </div>
@endsection
