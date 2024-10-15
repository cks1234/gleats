@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Client</h1>

        <form method="POST" action="{{ route('clients.store') }}">
            @csrf

            <div class="form-group mb-4">
                <label for="type">Account Type</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type"
                            id="individual" value="individual" {{ old('type') == 'individual' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="individual">Individual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type"
                            id="company" value="company" {{ old('type') == 'company' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="company">Company</label>
                    </div>
                </div>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group mb-4">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="phone">Phone (Optional)</label>
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                    name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="mobile">Mobile</label>
                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                    name="mobile" value="{{ old('mobile') }}" required>
                @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="postal_address">Postal Address</label>
                <input id="postal_address" type="text" class="form-control @error('postal_address') is-invalid @enderror"
                    name="postal_address" value="{{ old('postal_address') }}" required>
                @error('postal_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div id="addresses">
                <h4>Work Addresses (Optional)</h4>

                @if (old('addresses'))
                    @foreach (old('addresses') as $index => $address)
                        <div class="form-group mb-4">
                            <label for="address_name_{{ $index }}">Address Name</label>
                            <input id="address_name_{{ $index }}" type="text"
                                class="form-control @error('addresses.' . $index . '.name') is-invalid @enderror"
                                name="addresses[{{ $index }}][name]"
                                value="{{ old('addresses.' . $index . '.name') }}">
                            @error('addresses.' . $index . '.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="address_{{ $index }}">Address</label>
                            <input type="text"
                                class="form-control @error('addresses.' . $index . '.address') is-invalid @enderror"
                                name="addresses[{{ $index }}][address]" id="address_{{ $index }}"
                                value="{{ old('addresses.' . $index . '.address') }}">
                            @error('addresses.' . $index . '.address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endforeach
                @else
                    <div class="form-group mb-4">
                        <label for="address_name_0">Address Name</label>
                        <input type="text" class="form-control" name="addresses[0][name]" id="address_name_0"
                            value="{{ old('addresses.0.name') }}">
                    </div>

                    <div class="form-group mb-4">
                        <label for="address_0">Address</label>
                        <input type="text" class="form-control" name="addresses[0][address]" id="address_0"
                            value="{{ old('addresses.0.address') }}">
                    </div>
                @endif
            </div>

            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>

            <button type="button" class="btn btn-warning" id="add_address" onclick="add_address()">Add Another
                Address</button>

            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
    <script>
        let address_count = {{ old('addresses') ? count(old('addresses')) : 1 }};

        document.getElementById('add_address').addEventListener('click', function() {
            let address_div = document.getElementById('addresses');

            let new_address_html = `
                <div class="form-group mb-4">
                    <label for="address_name_${address_count}">Address Name</label>
                    <input type="text" class="form-control" name="addresses[${address_count}][name]" id="address_name_${address_count}" >
                </div>
    
                <div class="form-group mb-4">
                    <label for="address_${address_count}">Address</label>
                    <input type="text" class="form-control" name="addresses[${address_count}][address]" id="address_${address_count}" >
                </div>
            `;

            address_div.insertAdjacentHTML('beforeend', new_address_html);

            address_count++;
        });
    </script>


@endsection
