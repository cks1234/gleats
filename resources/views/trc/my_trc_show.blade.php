@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <h1>Test Report for Job #{{ $test_report->job->job_no }}
            </h1>
            <span style="font-size: 20px; padding: 10px 15px;"
                class="col-auto badge 
            @if ($test_report->status == 'pending') bg-warning 
            @elseif($test_report->status == 'signed') bg-success 
            @elseif($test_report->status == 'rejected') bg-danger @endif">
                {{ ucfirst($test_report->status) }}
            </span>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($test_report)
            <div>
                <h3 class="mb-3">Report Details</h3>
                @foreach (json_decode($test_report->report, true) as $response)
                    <div class="row">
                        <label><strong>{{ $response['question'] }}</strong></label>
                        <p>
                            @if ($response['response'] == 'yes' || $response['response'] == 'no')
                                {{ ucfirst($response['response']) }}
                            @else
                                {{ $response['response'] }}
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>

            @if (!empty($test_report->equipment))
                <div class="mb-3">
                    <label><strong>Equipment Used</strong></label>
                    <p>{{ $test_report->equipment }}</p>
                </div>
            @endif

            @if (!empty($test_report->electrical_work))
                <div class="mb-3">
                    <label><strong>Electrical Work</strong></label>
                    <p>{{ $test_report->electrical_work }}</p>
                </div>
            @endif

            @if (!empty($test_report->comments))
                <div class="mb-3">
                    <label><strong>Comments</strong></label>
                    <p>{{ $test_report->comments }}</p>
                </div>
            @endif

            <div class="mb-3">
                <label><strong>Supervisor Name</strong></label>
                <p>{{ $test_report->job->supervisor->name }}</p>
            </div>

            <div class="mb-3">
                <label><strong>Supervisor No. of Certificate of Competency</strong></label>
                <p>{{ $test_report->job->license->license }}</p>
            </div>


            <div class="d-flex flex-column">
                <label><strong>Supervisor Signature</strong></label>
                <img src="{{ $test_report->supervisor_signature }}" alt="Supervisor Signature"
                    style="border:1px solid #000; width: 400px; height: 200px;">
                <p><i>Date Signed: {{ $test_report->supervisor_signature_date->format('d M Y') }}</i></p>
            </div>

            @if ($test_report->contractor_signature)
                <div class="d-flex flex-column">
                    <label><strong>Contractor Signature</strong></label>
                    <img src="{{ $test_report->contractor_signature }}" alt="Contractor Signature"
                        style="border:1px solid #000; width: 400px; height: 200px;">
                    <p><i>Date Signed: {{ $test_report->contractor_signature_date->format('d M Y') }}</i></p>
                </div>
            @endif
        @else
            <p>No test report data available.</p>
        @endif

        <a href="{{ route('trc.my_trcs') }}" class="btn btn-secondary">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var canvas = document.getElementById('signature-pad');
            var signaturePad = new SignaturePad(canvas);

            var form = document.getElementById('test-report-form');
            form.addEventListener('submit', function(e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert('Provide a signature to proceed.');
                    document.getElementById('signature-error').style.display =
                        'block';
                    return false;
                } else {
                    var signatureData = signaturePad.toDataURL('image/png');
                    document.getElementById('signature').value = signatureData;
                }
            });

            document.getElementById('clear-signature').addEventListener('click', function() {
                signaturePad.clear();
            });
        });
    </script>
@endsection
