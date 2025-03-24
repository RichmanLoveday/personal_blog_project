<!DOCTYPE html>
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
    <title>Reset Password</title>
</head>

<body>
    <div class="login-logo">
        <img src="{{ asset('admin/assets/img/logo.png') }}" alt="img">
    </div>
    <h2>Hello, {{ $name }}</h2>
    <p>You requested a password reset. Click the button below:</p>
    <a href="{{ $resetUrl }}" style="padding: 10px; background-color: blue; color: white; text-decoration: none;">
        Reset Password
    </a>
    <p>This link will expire in {{ $expireTime }} minutes.</p>
</body>

</html>
