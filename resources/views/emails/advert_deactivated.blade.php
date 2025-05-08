<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Advert Deactivated</title>
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

        .content h1 {
            font-size: 22px;
            color: #e74c3c;
        }

        .content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #6c757d;
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

            .content h1 {
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
            <h1>📴 Advert Deactivated</h1>
            <p>Hello Admin,</p>
            <p>The following advert has been deactivated:</p>

            <p><strong>Title:</strong> {{ $advertTitle }}</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($advertStartDate)->format('F j, Y') }}</p>
            <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($advertEndDate)->format('F j, Y') }}</p>

            <p>This could be due to the advert reaching its end date or being manually removed. Please review for any
                necessary follow-up.</p>

            <a href="{{ $advertUrl }}" class="button" target="_blank">Review Advert</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
