<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @livewireStyles
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">GLEaTS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}">Home</a>
                    </li>
                    @if (in_array(Auth::user()->role, ['admin', 'manager', 'contractor']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/users') }}">Users</a>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role, ['admin', 'manager', 'contractor']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/clients') }}">Clients</a>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role, ['admin', 'manager', 'contractor']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/jobs') }}">Jobs</a>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role, ['admin', 'manager', 'contractor']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/trcs') }}">TRCs</a>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role, ['manager', 'contractor', 'tradesperson', 'labourer']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/my_jobs') }}">My Jobs</a>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role, ['manager', 'contractor', 'tradesperson', 'labourer']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/my_trcs') }}">My TRCs</a>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role, ['manager', 'contractor', 'tradesperson', 'labourer']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/my_licenses') }}">My Licenses</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content m-4">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
