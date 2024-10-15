@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Job</h1>

        <form method="POST" action="{{ route('jobs.store') }}">
            @csrf

            <div class="form-group mb-4">
                <label for="client_id">Client</label>
                <select id="client_id" class="form-control @error('client_id') is-invalid @enderror" name="client_id" required>
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="supervisor_id">Supervisor (Optional)</label>
                <select id="supervisor_id" class="form-control @error('supervisor_id') is-invalid @enderror"
                    name="supervisor_id">
                    <option value="">Select Supervisor</option>
                    @foreach ($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}"
                            {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                            {{ $supervisor->name }}
                        </option>
                    @endforeach
                </select>
                @error('supervisor_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4" id="license_group" style="display: none;">
                <label for="license_id">License</label>
                <select id="license_id" class="form-control @error('license_id') is-invalid @enderror" name="license_id">
                    <option value="">Select License</option>
                </select>
                @error('license_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="type">Job Type</label>
                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                    <option value="">Select Job Type</option>
                    <option value="electrical" {{ old('type') == 'electrical' ? 'selected' : '' }}>Electrical</option>
                    <option value="hardware" {{ old('type') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="data" {{ old('type') == 'data' ? 'selected' : '' }}>Data</option>
                </select>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="work_address_id">Work Address</label>
                <select id="work_address_id" class="form-control @error('work_address_id') is-invalid @enderror"
                    name="work_address_id" required>
                    <option value="">Select Client</option>
                </select>
                @error('work_address_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="description">Description (Optional)</label>
                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <input hidden value="pending" id="status" name="status">

            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const client_id_element = document.getElementById('client_id');
            const address_select = document.getElementById('work_address_id');
            const supervisor_element = document.getElementById('supervisor_id');
            const license_group = document.getElementById('license_group');
            const license_select = document.getElementById('license_id');
            const old_work_address_id = "{{ old('work_address_id') }}";
            const old_license_id = "{{ old('license_id') }}";

            function fetch_and_populate_addresses(client_id) {
                if (client_id) {
                    fetch(`/api/clients/${client_id}/addresses`)
                        .then(response => response.json())
                        .then(data => {
                            address_select.innerHTML = '';

                            if (data.addresses.length > 0) {
                                const default_option = document.createElement('option');
                                default_option.value = "";
                                default_option.textContent = 'Select Address';
                                address_select.appendChild(default_option);

                                data.addresses.forEach(address => {
                                    const option = document.createElement('option');
                                    option.value = address.id;
                                    option.textContent = `${address.name} - ${address.address}`;

                                    if (address.id == old_work_address_id) {
                                        option.selected = true;
                                    }

                                    address_select.appendChild(option);
                                });
                            } else {
                                const option = document.createElement('option');
                                option.value = "";
                                option.textContent = 'No addresses';
                                address_select.appendChild(option);
                            }
                        })
                        .catch(error => {
                            address_select.innerHTML = '<option value="">Unable to fetch addresses</option>';
                        });
                } else {
                    address_select.innerHTML = '<option value="">Select Client</option>';
                }
            }

            function fetch_and_populate_licenses(supervisor_id) {
                if (supervisor_id) {
                    license_group.style.display = 'block';

                    fetch(`/api/users/${supervisor_id}/licenses`)
                        .then(response => response.json())
                        .then(data => {
                            license_select.innerHTML = '';

                            if (data.licenses.length > 0) {
                                const default_option = document.createElement('option');
                                default_option.value = "";
                                default_option.textContent = 'Select License';
                                license_select.appendChild(default_option);

                                data.licenses.forEach(license => {
                                    const option = document.createElement('option');
                                    option.value = license.id;
                                    option.textContent = license.type;

                                    if (license.id == old_license_id) {
                                        option.selected = true;
                                    }

                                    license_select.appendChild(option);
                                });
                            } else {
                                const no_license_option = document.createElement('option');
                                no_license_option.value = "";
                                no_license_option.textContent = 'No licenses found';
                                license_select.appendChild(no_license_option);
                            }
                        })
                        .catch(() => {
                            license_select.innerHTML = '<option value="">Unable to fetch licenses</option>';
                        });
                } else {
                    license_group.style.display = 'none';
                    license_select.innerHTML = '<option value="">Select Supervisor</option>';
                }
            }

            const client_id = client_id_element.value;
            if (client_id) {
                fetch_and_populate_addresses(client_id);
            }

            const supervisor_id = supervisor_element.value;
            if (supervisor_id) {
                fetch_and_populate_licenses(supervisor_id);
            }

            client_id_element.addEventListener('change', function() {
                const selected_client_id = this.value;
                fetch_and_populate_addresses(selected_client_id);
            });

            supervisor_element.addEventListener('change', function() {
                const selected_supervisor_id = this.value;
                fetch_and_populate_licenses(selected_supervisor_id);
            });

            @if ($errors->has('license_id'))
                license_group.style.display = 'block';
            @endif
        });
    </script>
@endsection
