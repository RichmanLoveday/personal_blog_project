<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contact Message</title>
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
            color: #3490dc;
        }

        .content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .message-box {
            background-color: #f9f9f9;
            padding: 18px;
            border-left: 4px solid #3490dc;
            border-radius: 6px;
            margin-top: 15px;
            white-space: pre-line;
            color: #333;
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
            <h1>📨 New Message from {{ $name }}</h1>

            <div class="message-box">
                {{ $message }}
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
