<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.jpg') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="w-100">
                    <div class=" d-flex justify-content-center border border-danger">
                        <div class="login-content">
                            <div class="login-userset">
                                <div class="login-logo">
                                    <img src="{{ asset('admin/assets/img/logo.png') }}" alt="img">
                                </div>

                                <div class="login-userheading">
                                    <h3>Reset Link</h3>
                                    {{-- <h4>Please enter  to your account</h4> --}}
                                </div>
                                <form action="{{ route('author.password.resetlink') }}" method="post">
                                    @csrf
                                    <div class="form-login">
                                        <label>Email</label>
                                        <div class="form-addons">
                                            <input type="text" name="email" placeholder="Enter your email address"
                                                class="@error('email') is-invalid @enderror">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <img src="{{ asset('admin/assets/img/icons/mail.svg') }}" alt="img">
                                        </div>
                                    </div>

                                    <div class="form-login">
                                        <button class="btn btn-login" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/script.js') }}"></script>

    <div class="sidebar-overlay"></div>

    @if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}");
            });
        </script>
    @endif


    @if (session('status'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('status') }}");
            });
        </script>
    @endif
</body>

</html>
