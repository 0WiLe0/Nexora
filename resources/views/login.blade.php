<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nexora — Sign In</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }} ">
</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="brand">
            <img src="{{asset('img/logo.svg')}}" class="brand-logo" alt="">
            <div class="brand-title">NEXORA <span>PERFORMANCE</span></div>
        </div>

        <h1 class="login-title">Welcome Back</h1>
        <p class="login-subtitle">Sign in to continue to your profile</p>

        <div class="steam-box">
            <img src="{{asset('img/steam.svg')}}" class="steam-icon" alt="">
            <span class="steam-text">Sign in through Steam</span>
        </div>

        <a href="/auth/steam" class="login-btn">
            <img src="{{asset('img/steam.svg')}} " class="login-btn-icon" alt="">
            Sign in with Steam
        </a>

        <div class="privacy-text">
            By logging in, you agree to our
            <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.
        </div>

    </div>

</div>

</body>
</html>
