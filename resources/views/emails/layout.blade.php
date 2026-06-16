<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0; padding: 0;
            background-color: #FFF5F5;
            font-family: 'Montserrat', Arial, sans-serif;
            color: #2d2d2d;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .header {
            background-color: #C1121F;
            padding: 32px 40px;
            text-align: center;
        }
        .header-title {
            font-family: 'Lora', Georgia, serif;
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }
        .body {
            padding: 40px;
        }
        .body h1, .body h2 {
            font-family: 'Lora', Georgia, serif;
            color: #C1121F;
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .body p {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 15px;
            line-height: 1.7;
            color: #2d2d2d;
            margin: 0 0 14px;
        }
        .body strong {
            color: #C1121F;
            font-weight: 700;
        }
        .body a.btn {
            display: inline-block;
            margin-top: 12px;
            padding: 12px 28px;
            background-color: #C1121F;
            color: #ffffff;
            font-family: 'Montserrat', Arial, sans-serif;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            border-radius: 4px;
        }
        .divider {
            border: none;
            border-top: 1px solid #f0e0e0;
            margin: 24px 0;
        }
        .note {
            font-size: 12px;
            color: #999;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <p class="header-title">Le Fil Rouge</p>
        </div>
        <div class="body">
            @yield('content')
        </div>
    </div>
</body>
</html>
