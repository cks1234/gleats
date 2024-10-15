<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        if ($user->role == 'admin') {
            abort(403, 'Admins cannot have licenses.');
        }

        $licenses = $user->licenses;
        return view('licenses.index', compact('user', 'licenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        if ($user->role == 'admin') {
            abort(403, 'Admins cannot have licenses.');
        }
        return view('licenses.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'type' => ['required', 'string', 'max:50'],
            'license' => ['required', 'string', 'max:20', 'unique:licenses,license'],
            'expiry' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        if ($user->role == 'admin') {
            abort(403, 'Admins cannot have licenses.');
        }

        License::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'license' => $request->license,
            'expiry' => $request->expiry,
        ]);

        return redirect()->route('users.index')->with('success', 'License added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(License $license)
    {
        if ($license->user->role == 'admin') {
            abort(403, 'Admins cannot have licenses.');
        }
        return view('licenses.edit', compact('license'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, License $license)
    {
        $request->validate([
            'type' => ['required', 'string', 'max:50'],
            'license' => ['required', 'string', 'max:20', 'unique:licenses,license,' . $license->id],
            'expiry' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        if ($license->user->role == 'admin') {
            abort(403, 'Admins cannot have licenses.');
        }

        $license->fill([
            'type' => $request->type,
            'license' => $request->license,
            'expiry' => $request->expiry,
        ]);

        if (!$license->isDirty()) {
            return redirect()->route('licenses.index', $license->user_id);
        }

        $license->save();

        return redirect()->route('licenses.index', $license->user_id)->with('success', 'License updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(License $license)
    {
        $license->delete();

        return redirect()->route('licenses.index', $license->user_id)->with('success', 'License deleted successfully.');
    }


    public function my_licenses()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            abort(403, 'Admins cannot have licenses.');
        }

        $licenses = $user->licenses;

        return view('licenses.my_licenses', compact('user', 'licenses'));
    }
}
