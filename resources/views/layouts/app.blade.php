<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Nexora')</title>

    <link href="https://fonts.googleapis.com/css2?family=Lalezar&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @stack('styles')
</head>
<body>


<div class="party-toast hidden">
    <div class="party-toast__content">

        <div class="party-toast__header">
            <div class="party-toast__avatar">
                <img src="" alt="avatar">
            </div>

            <div class="party-toast__info">
                <div class="party-toast__nickname">WILE</div>

                <div class="party-toast__rating">
                    <svg width="14" height="14" viewBox="0 0 24 24">
                        <path fill="#8b5cf6"
                              d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8Z"/>
                    </svg>
                    <span>2450</span>
                </div>
            </div>
        </div>

        <div class="party-toast__text">
            invited you to a party
        </div>

        <div class="party-toast__actions">
            <button class="party-toast__accept">Accept</button>
            <button class="party-toast__decline">Decline</button>
        </div>

    </div>
</div>



@include('layouts.partials.sidebar')

@yield('content')


<script>
    window.__ME_ID__ = {{ auth()->id() }};
    window.__PARTY_ID__ = {{ $partyId ?? 'null' }};
    window.__ME_AVATAR__ = '{{ $user->avatar ?? 'null' }}';
</script>

<script type="module" src="{{ asset('js/app.js') }}"></script>


</body>
</html>
