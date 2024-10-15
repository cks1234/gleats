@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Job {{ $job->job_no }}</h1>

        <form method="POST" action="{{ route('jobs.update', $job->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label for="job_no">Job Number</label>
                <input id="job_no" type="text" class="form-control @error('job_no') is-invalid @enderror" name="job_no"
                    value="{{ old('job_no', $job->job_no) }}" readonly>
                @error('job_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="client_id">Client</label>
                <select id="client_id" class="form-control @error('client_id') is-invalid @enderror" name="client_id"
                    required>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ old('client_id', $job->client_id) == $client->id ? 'selected' : '' }}>
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
                <label for="supervisor_id">Supervisor</label>
                <select id="supervisor_id" class="form-control @error('supervisor_id') is-invalid @enderror"
                    name="supervisor_id">
                    <option value="">Unassigned</option>
                    @foreach ($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}"
                            {{ old('supervisor_id', $job->supervisor_id) == $supervisor->id ? 'selected' : '' }}>
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

            <div class="form-group mb-4" id="license_group"
                style="{{ old('supervisor_id', $job->supervisor_id) ? '' : 'display: none;' }}">
                <label for="license_id">License</label>
                <select id="license_id" class="form-control @error('license_id') is-invalid @enderror" name="license_id">
                    <option value="">Select License</option>
                    @foreach ($licenses as $license)
                        <option value="{{ $license->id }}"
                            {{ old('license_id', $job->license_id) == $license->id ? 'selected' : '' }}>
                            {{ $license->type }}
                        </option>
                    @endforeach
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
                    <option value="electrical" {{ old('type', $job->type) == 'electrical' ? 'selected' : '' }}>Electrical
                    </option>
                    <option value="hardware" {{ old('type', $job->type) == 'hardware' ? 'selected' : '' }}>Hardware
                    </option>
                    <option value="data" {{ old('type', $job->type) == 'data' ? 'selected' : '' }}>Data</option>
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
                    <option value="">Select Address</option>
                    @foreach ($job->client->addresses as $address)
                        <option value="{{ $address->id }}"
                            {{ old('work_address_id', $job->work_address_id) == $address->id ? 'selected' : '' }}>
                            {{ $address->name }} - {{ $address->address }}
                        </option>
                    @endforeach
                </select>
                @error('work_address_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="description">Description (Optional)</label>
                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $job->description) }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="status">Status</label>
                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                    <option value="pending" {{ old('status', $job->status) == 'pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="completed" {{ old('status', $job->status) == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const supervisor_element = document.getElementById('supervisor_id');
            const license_group = document.getElementById('license_group');
            const license_select = document.getElementById('license_id');

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

                                    if (license.id == "{{ old('license_id', $job->license_id) }}") {
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

            supervisor_element.addEventListener('change', function() {
                const selected_supervisor_id = this.value;
                fetch_and_populate_licenses(selected_supervisor_id);
            });

            const supervisor_id = supervisor_element.value;
            if (supervisor_id) {
                fetch_and_populate_licenses(supervisor_id);
            }
        });
    </script>
@endsection
