<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>

<body style="margin:0;background:#F8FAFC;font-family:Arial,sans-serif;">

<div style="max-width:500px;margin:60px auto;padding:40px;">

    <div style="text-align:center;margin-bottom:32px;">
   
    <img src="{{ asset('storage/email.png') }}" alt="Logo" width="150" style="display:block;margin:0 auto;">
    </div>

    <h1 style="
        font-size:40px;
        font-weight:700;
        line-height:1.15;
        color:#111827;
        text-align:center;
        margin:0 0 32px;
    ">
        Verify your email<br>
        address to get started
    </h1>

    <p style="font-size:18px;color:#111827;margin-bottom:18px; font-weight:400">
        Hi {{ $name }},
    </p>

    <p style="
        font-size:18px;
        line-height:1.7;
        color:black;
        margin-bottom:48px;
        font-weight:400;
    ">
        {{$text}}
    </p>

    <div style="text-align:center;">
        <a href="{{ $url }}"
           style="
                display:inline-block;
                background:#4B69FD;
                color:#fff;
                text-decoration:none;
                padding:10px 24px;
                border-radius:12px;
                font-weight:700;
                font-size:16px;
                width:188px;
            ">
            Verify now
        </a>
    </div>

</div>

</body>
</html>
