<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Client $client)
    {
        $addresses = $client->addresses;
        return view('clients.addresses.index', compact('client', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Client $client)
    {
        return view('clients.addresses.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $validated['client_id'] = $client->id;

        Address::create($validated);

        return redirect()->route('clients.addresses.index', $client->id)->with('success', 'Address added successfully.');
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
    public function edit(Client $client, Address $address)
    {
        if ($address->client_id !== $client->id) {
            return redirect()->route('clients.addresses.index', $client->id)->with('error', 'This address does not belong to the selected client.');
        }

        return view('clients.addresses.edit', compact('client', 'address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client, Address $address)
    {
        if ($address->client_id !== $client->id) {
            return redirect()->route('clients.addresses.index', $client->id)->with('error', 'This address does not belong to the selected client.');
        }

        $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
            ]);

        $address->fill($request->all());

        if (!$address->isDirty()) {
            return redirect()->route('clients.addresses.index', $client->id);
        }

        $address->save();

        return redirect()->route('clients.addresses.index', $client->id)->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client, Address $address)
    {
        if ($address->client_id !== $client->id) {
            return redirect()->route('clients.addresses.index', $client->id)->with('error', 'This address does not belong to the selected client.');
        }

        $address->delete();

        return redirect()->route('clients.addresses.index', $client->id)->with('success', 'Address deleted successfully.');
    }

    public function get_client_addresses(Client $client)
    {
        return response()->json([
            'addresses' => $client->addresses()->get(['id', 'name', 'address']),
        ]);
    }
}
