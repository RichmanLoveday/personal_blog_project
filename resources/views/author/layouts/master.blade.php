<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dreams Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.jpg') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-datetimepicker.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>

    <!-- JQUERY -->
    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">

        <div class="header">
            <div class="header-left active">
                <a href="index.html" class="logo">
                    <img src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="{{ asset('admin/assets/img/logo-small.png') }}" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img style="width: 50px; height:40px;"
                                src="{{ !is_null(Auth::user()->photo) ? asset(Auth::user()->photo) : asset('admin/assets/img/icons/person_icon.png') }}"
                                alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img style="width: 50px; height:40px;"
                                        src="{{ !is_null(Auth::user()->photo) ? asset(Auth::user()->photo) : asset('admin/assets/img/icons/person_icon.png') }}"
                                        alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ Str::ucfirst(Auth::user()->firstName) . ' ' . Str::ucfirst(Auth::user()->lastName) }}
                                    </h6>
                                    <h5>{{ Str::ucfirst(Auth::user()->role) }}</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="{{ route('author.profile', Auth::user()->id) }}"> <i
                                    class="me-2" data-feather="user"></i>
                                My Profile</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="{{ route('author.logout') }}"><img
                                    src="{{ asset('admin/assets/img/icons/log-out.svg') }}" class="me-2"
                                    alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="{{ route('author.dashboard') }}"><img
                                    src="{{ asset('admin/assets/img/icons/dashboard.svg') }}" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img
                                    src="{{ asset('admin/assets/img/icons/article.png') }}" alt="img"><span>
                                    Article Management</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('author.articles') }}">All Articles</a></li>
                                <li><a href="{{ route('article.publish') }}">Published Articles</a></li>
                                <li><a href="{{ route('article.draft') }}">Drafted Articles</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{ asset('admin/assets/img/icons/advert.png') }}"
                                    alt="img"><span> Advert Management</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('advert.index') }}">All Adverts </a></li>
                                <li><a href="newuser.html">Active Adverts </a></li>
                                <li><a href="userlists.html">Inactive Adverts</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>




    <script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('admin/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

</body>

</html>
