<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'DeckBrain') }}</title>

        {{-- Stile personalizzato per le pagine guest (login, register, ecc.) --}}
        <link rel="stylesheet" href="{{ asset('css/guest.css') }}">
        {{-- NIENTE @vite QUI --}}
    </head>

    <body>
        <div class="guest-wrapper">
            <div class="guest-card">
                <h1 class="guest-title">{{ $title ?? '' }}</h1>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>