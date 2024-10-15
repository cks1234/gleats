<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Job;
use App\Models\License;
use App\Models\TestReportCertificate;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();
        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $supervisors = User::whereNotIn('role', ['admin', 'labourer'])->get();
        return view('jobs.create', compact('clients', 'supervisors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:electrical,hardware,data'],
            'client_id' => ['required', 'exists:clients,id'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
            'work_address_id' => ['required', 'exists:addresses,id'],
            'description' => ['nullable', 'string'],
            'license_id' => ['nullable', 'exists:licenses,id', 'required_with:supervisor_id'],
            'status' => ['required', 'in:pending,completed'],
        ]);

        if ($this->is_admin_or_labourer($request->input('supervisor_id'))) {
            abort(403, 'Admin or labourers cannot have jobs.');
        }

        $client = Client::findOrFail($validated['client_id']);

        if (!$client->addresses()->where('id', $validated['work_address_id'])->exists()) {
            return redirect()->back()->withErrors(['work_address_id' => 'The selected address does not belong to the selected client.'])->withInput();
        }

        if (!empty($validated['supervisor_id']) && !empty($validated['license_id'])) {
            $supervisor = User::findOrFail($validated['supervisor_id']);
            if (!$supervisor->licenses()->where('id', $validated['license_id'])->exists()) {
                return redirect()->back()->withErrors(['license_id' => 'The selected license does not belong to the selected supervisor.'])->withInput();
            }
        }

        $job = Job::create([
            'job_no' => $this->generate_job_number(),
            'type' => $validated['type'],
            'client_id' => $validated['client_id'],
            'supervisor_id' => $validated['supervisor_id'],
            'license_id' => $validated['license_id'],
            'work_address_id' => $validated['work_address_id'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('jobs.show', $job->id)->with('success', 'Job created successfully.');
    }

    protected function is_admin_or_labourer($user_id)
    {
        $user = User::find($user_id);

        if ($user && in_array($user->role, ['admin', 'labourer'])) {
            return true;
        }

        return false;
    }

    protected function generate_job_number()
    {
        $year = Carbon::now()->format('y');
        $quarter = ceil(Carbon::now()->month / 3);
        $job_count = Job::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', '>=', ($quarter - 1) * 3 + 1)
        ->whereMonth('created_at', '<=', $quarter * 3)
        ->count() + 1;
        $job_count_formatted = $this->format_job_count($job_count);

        $job_no = 'J' . $year . $quarter . $job_count_formatted;

        return $job_no;
    }

    protected function format_job_count($number)
    {
        $number = (string) $number;

        if (strlen($number) === 1) {
            return '00' . $number;
        } elseif (strlen($number) === 2) {
            return '0' . $number;
        } else {
            return $number;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $clients = Client::all();
        $supervisors = User::whereNotIn('role', ['admin', 'labourer'])->get();
        $licenses = [];
        if ($job->supervisor_id) {
            $licenses = License::where('user_id', $job->supervisor_id)->get();
        }
        return view('jobs.edit', compact('job', 'clients', 'supervisors', 'licenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:electrical,hardware,data'],
            'client_id' => ['required', 'exists:clients,id'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
            'license_id' => ['nullable', 'exists:licenses,id', 'required_with:supervisor_id'],
            'work_address_id' => ['required', 'exists:addresses,id'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,completed'],
        ]);

        if ($this->is_admin_or_labourer($request->input('supervisor_id'))) {
            abort(403, 'Admin or labourers cannot have jobs.');
        }

        $client = Client::findOrFail($validated['client_id']);

        if (!$client->addresses()->where('id', $validated['work_address_id'])->exists()) {
            return redirect()->back()->withErrors(['work_address_id' => 'The selected address does not belong to the selected client.'])->withInput();
        }

        if (!empty($validated['supervisor_id']) && !empty($validated['license_id'])) {
            $supervisor = User::findOrFail($validated['supervisor_id']);
            if (!$supervisor->licenses()->where('id', $validated['license_id'])->exists()) {
                return redirect()->back()->withErrors(['license_id' => 'The selected license does not belong to the selected supervisor.'])->withInput();
            }
        }

        $job->fill([
            'type' => $validated['type'],
            'client_id' => $validated['client_id'],
            'supervisor_id' => $validated['supervisor_id'],
            'license_id' => $validated['license_id'],
            'work_address_id' => $validated['work_address_id'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        if (!$job->isDirty()) {
            return redirect()->route('jobs.show', $job->id);
        }

        $job->save();

        return redirect()->route('jobs.show', $job->id)->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }

    public function my_jobs()
    {
        if ($this->is_admin_or_labourer(auth()->id())) {
            abort(403, 'Admin or labourers cannot have jobs.');
        }

        $jobs = Job::where('supervisor_id', auth()->id())->get();
        return view('jobs.my_jobs', compact('jobs'));
    }

    public function change_status(Job $job)
    {
        $job->status = $job->status === 'pending' ? 'completed' : 'pending';
        $job->save();

        return redirect()->route('jobs.show', $job->id)->with('success', 'Job status changed successfully.');
    }

    public function my_job_show(Job $job)
    {
        if ($this->is_admin_or_labourer(auth()->id())) {
            abort(403, 'Admin or labourers cannot have jobs.');
        }

        if ($job->supervisor_id !== auth()->id()) {
            abort(403, 'You can only view your jobs.');
        }

        return view('jobs.my_jobs_show', compact('job'));
    }
}
