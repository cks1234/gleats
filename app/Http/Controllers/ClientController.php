<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:individual,company'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Client::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['required', 'string', 'max:20'],
            'postal_address' => ['required', 'string', 'max:255'],
            'addresses.*.name' => ['nullable', 'string', 'max:255', 'required_with:addresses.*.address'],
            'addresses.*.address' => ['nullable', 'string', 'max:255', 'required_with:addresses.*.name'],
        ], [
            'addresses.*.name.required_with' => 'The address name field is required when an address is provided.',
            'addresses.*.address.required_with' => 'The address field is required when an address name is provided.',
        ]);

        $client = Client::create([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'mobile' => $validated['mobile'],
            'postal_address' => $validated['postal_address'],
        ]);

        if (!empty($validated['addresses'])) {
            foreach ($validated['addresses'] as $address_data) {
                if (!empty($address_data['name']) && !empty($address_data['address'])) {
                    $client->addresses()->create($address_data);
                }
            }
        }

        return redirect()->route('clients.index')->with('success', 'Client added successfully.');
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
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'type' => ['required', 'in:individual,company'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:clients,email,' . $client->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['required', 'string', 'max:20'],
            'postal_address' => ['required', 'string', 'max:255'],
        ]);

        $client->fill($request->all());

        if (!$client->isDirty()) {
            return redirect()->route('clients.index');
        }

        $client->save();

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
