<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\TestReportCertificate;
use App\Models\Job;
use Mpdf\Mpdf;

class TestReportCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trcs = TestReportCertificate::all();
        return view('trc.index', compact('trcs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $job_id = $request->input('job_id');
        $job = Job::find($job_id);

        if (isset($job)) {
            if (auth()->id() !== $job->supervisor_id) {
                abort(403, 'You can only generate test report of your assigned jobs.');
            }
        } else {
            abort(403, 'Job does not exists.');
        }

        return view('trc.create', compact('job'));
    }

    public function preview(Request $request)
    {
        $job = session('job');
        $responses = session('responses');

        if (!$responses || !$job) {
            return redirect()->route('jobs.my_jobs');
        }

        return view('trc.preview', compact('job', 'responses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'equipment' => 'nullable|string|max:1000',
            'electrical_work' => 'nullable|string|max:1000',
            'comments' => 'nullable|string|max:1000',
            'signature' => 'required|string',
            'responses' => 'required',
        ]);

        $responses = json_decode($request->input('responses'), true);

        TestReportCertificate::create([
        'supervisor_id' => auth()->id(),
        'job_id' => $validated['job_id'],
        'report' => json_encode($responses),
        'equipment' => $validated['equipment'],
        'electrical_work' => $validated['electrical_work'],
        'comments' => $validated['comments'],
        'supervisor_signature' => $validated['signature'],
        'supervisor_signature_date' => now(),
        'status' => 'pending',
    ]);
        return redirect()->route('trc.my_trcs')->with('success', 'Test report submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $test_report = TestReportCertificate::with('job')->findOrFail($id);

        return view('trc.show', compact('test_report'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function my_trcs()
    {
        $trcs = TestReportCertificate::whereHas('job', function ($query) {
            $query->where('supervisor_id', auth()->id());
        })->get();
        return view('trc.my_trcs', compact('trcs'));
    }

    public function my_trc_show($id)
    {

        $test_report = TestReportCertificate::with('job')->findOrFail($id);

        if ($test_report->job->supervisor->id !== auth()->id()) {
            abort(403, 'You can only view your test report certificates.');
        }

        return view('trc.my_trc_show', compact('test_report'));
    }

    public function sign(Request $request, $id)
    {
        $validated = $request->validate([
            'signature' => 'required|string',
        ]);

        $test_report = TestReportCertificate::findOrFail($id);

        $test_report->contractor_signature = $validated['signature'];
        $test_report->contractor_signature_date = now();
        $test_report->status = 'signed';
        $test_report->save();

        return redirect()->route('trc.show', $test_report->id);
    }

    public function reject($id)
    {
        $test_report = TestReportCertificate::findOrFail($id);

        $test_report->contractor_signature = null;
        $test_report->contractor_signature_date = null;
        $test_report->status = 'rejected';
        $test_report->save();

        return redirect()->route('trc.show', $test_report->id);
    }

    public function pending($id)
    {
        $test_report = TestReportCertificate::findOrFail($id);

        $test_report->contractor_signature = null;
        $test_report->contractor_signature_date = null;
        $test_report->status = 'pending';
        $test_report->save();

        return redirect()->route('trc.show', $test_report->id);
    }

    public function generatePdf($id)
    {
        $testReport = TestReportCertificate::with('job')->findOrFail($id);

        $html = view('trc.pdf', compact('testReport'))->render();

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($html);

        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');

        return $mpdf->Output('test_report_' . $testReport->job->job_no . '.pdf', 'I');
    }
}
