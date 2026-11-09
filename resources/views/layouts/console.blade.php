<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('css/console/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ mix('css/console.css') }}" rel="stylesheet">
    @stack('css')
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="{{ asset('css/console/examples.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link defer href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles

</head>

<body>
    @stack('notify')
    
    @include('layouts.console-nav')
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <header class="header header-sticky mb-4">
            <div class="container-fluid">
                <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                    <span class="material-icons md-dark" style="margin-top: 9px;">menu</span>
                </button>

              
                <ul class="header-nav ms-3 ">
                    <div class="d-flex flex-row">
                        <p class="align-self-center font-weight-bold" style="margin-top: 10px;">{{ Auth::user()->name }}</p>
                    </div>
                    
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-md">
                                <img class="avatar-img" src="{{ asset('assets/img/avatar-1.png') }}">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="dropdown-header bg-light py-2">
                                <div class="fw-semibold">{{ Auth::user()->role }}</div>
                            </div>
                            <a class="dropdown-item" href="{{ route('console.profile.change.password', Auth::user()->id) }}">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                            
                            <a class="dropdown-item" href="{{ route('console.logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                        {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('console.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="header-divider"></div>
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    @yield('nav')
                </nav>
            </div>
        </header>
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="row w-100">
                <div class="col-sm-12 col-md-6">
                    <a href="#">Baracoal Container Management System</a> © 2022.
                </div>
                <div class="col-sm-12 col-md-6 d-flex justify-content-end"> 
                    Powered by&nbsp;<a href="https://www.baracoal.com/">PT. Bara Alam Utama </a>
                </div>
            </div>
        </footer>
    </div>
    <!-- and necessary plugins-->
    <script src="{{ mix('js/console.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @stack('scripts')
    @livewireScripts
    @livewireChartsScripts
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>

</body>

</html>
