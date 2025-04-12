<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
        }

        .header img.logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .content h2 {
            font-size: 22px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 13px;
            color: #888;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .content h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="{{ asset('admin/assets/img/logo.png') }}" alt="Logo" class="logo">
        </div>

        <div class="content">
            <h2>Hello, {{ $name }}</h2>
            <p>We received a request to reset your password. Click the button below to choose a new password.</p>
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            <p>This link will expire in <strong>{{ $expireTime }}</strong> minutes.</p>
            <p>If you didn’t request a password reset, you can safely ignore this email.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
