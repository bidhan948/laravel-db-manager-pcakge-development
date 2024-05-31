<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/bidhan/bhadhan/css/main.css') }}">
    <title>@yield('title', 'DB - SCHEMA')</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link f-w-b-1" href="{{ url('check-check') }}">Dashboard <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link f-w-b-1 {{ Request::is('bhadhan/db-manager/schema') ? 'active-link' : '' }}"
                        href="{{ route('bhadhan-db-manager.schema') }}">Schema</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link f-w-b-1 {{ Request::is('bhadhan/db-manager/performance-metrics') ? 'active-link' : '' }}"
                        href="{{ route('bhadhan-db-manager.performance') }}">Performance Metrics</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link f-w-b-1 dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-lg-0">
                <input class="form-control form-control-sm mr-sm-2 h-25" type="search" placeholder="Search"
                    aria-label="Search">
                <button class="btn btn-outline-success btn-sm my-sm-0 top-bar-button" type="submit">Search</button>
            </form>
        </div>
    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    @yield('scripts')
</body>

</html>
