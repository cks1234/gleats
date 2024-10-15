@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Test Report Preview for Job #{{ $job->job_no }}</h1>

        @if ($responses)
            <div>
                <h3 class="mb-3">Report Details</h3>
                @foreach ($responses as $response)
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

            <form id="test-report-form" method="POST" action="{{ route('trc.store') }}">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <input type="hidden" name="responses" value="{{ json_encode($responses) }}">
                <div class="form-group mb-3">
                    <label for="equipment">Equipment Used (Optional)</label>
                    <textarea name="equipment" id="equipment" class="form-control" rows="3" placeholder="Equipment details"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="electrical_work">Electrical Work (Optional)</label>
                    <textarea name="electrical_work" id="electrical_work" class="form-control" rows="3"
                        placeholder="Details of electrical work that is not requird to be inspected by an installation inspector and that has been tested and connected. eg: site location, circuit number, location of equipment, switchboard I.D."></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="comments">Comments (Optional)</label>
                    <textarea name="comments" id="comments" class="form-control" rows="3" placeholder="Comment"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="supervisor_name">Supervisor Name</label>
                    <p><strong>{{ $job->supervisor->name }}</strong></p>
                </div>
                <div class="form-group mb-3">
                    <label for="supervisor_name">Supervisor No. of Certificate of Competency</label>
                    <p><strong>{{ $job->license->license }}</strong></p>
                </div>
                <div class="form-group mb-3">
                    <label for="signature">Supervisor Signature</label>

                    <div class="d-flex flex-column">
                        <canvas id="signature-pad" class="signature-pad" width="400" height="200"
                            style="border: 1px solid black; width: 400px; height: 200px;"></canvas>
                        <input type="hidden" name="signature" id="signature">
                        <button type="button" id="clear-signature" class="btn btn-warning mt-2 align-self-start">Clear
                            Signature</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        @else
            <p>No data available for preview.</p>
        @endif
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
