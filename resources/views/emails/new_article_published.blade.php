<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Blog Post</title>
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

        .article-image {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .content h1 {
            font-size: 24px;
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

        .social-icons img {
            width: 24px;
            margin: 0 6px;
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

        <img src="{{ $articleImage }}" alt="Article Image" class="article-image">

        <div class="content">
            <h1>{{ $articleTitle }}</h1>
            <p>{{ $articleSummary }}</p>
            <a href="{{ $articleUrl }}" class="button">Read Full Article</a>
        </div>

        <div class="footer">
            <div class="social-icons">
                <a href="https://facebook.com/yourpage"><img src="https://img.icons8.com/color/48/facebook.png"
                        alt="Facebook" /></a>
                <a href="https://twitter.com/yourprofile"><img src="https://img.icons8.com/color/48/twitter.png"
                        alt="Twitter" /></a>
                <a href="https://instagram.com/yourpage"><img src="https://img.icons8.com/color/48/instagram-new.png"
                        alt="Instagram" /></a>
            </div>
            <p>&copy; {{ date('Y') }} Your Blog. All rights reserved.</p>
            <p><a href="{{ $unsubscribeLink }}" style="color: #007bff;">Unsubscribe</a></p>
        </div>
    </div>

</body>

</html>
