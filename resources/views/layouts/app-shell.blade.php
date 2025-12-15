<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'DeckBrain') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS layout + homepage --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    {{-- CSS del deck builder --}}
    <link rel="stylesheet" href="{{ asset('css/deckbuilder.css') }}">

    @livewireStyles
</head>
<body class="hp-body">

    {{-- HEADER --}}
    <header class="hp-header">
        <div class="hp-header-left">
            <div class="hp-logo">
                OP DeckBrain
            </div>
        </div>

        <div class="hp-header-right">
            @guest
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="hp-btn hp-btn-ghost">Login</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hp-btn hp-btn-primary">Registrati</a>
                @endif
            @endguest

            @auth
                <span class="hp-user-label">Ciao, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="hp-btn hp-btn-ghost">Logout</button>
                </form>
            @endauth
        </div>
    </header>

    <div class="hp-layout">
        {{-- SIDEBAR --}}
        <aside class="hp-sidebar">
            <div class="hp-menu-title">Navigazione</div>
            <nav class="hp-menu">
                <a href="{{ route('home') }}"
                   class="hp-menu-item {{ request()->routeIs('home') ? 'hp-menu-item--active' : '' }}">
                    <span class="hp-menu-item-icon">🏠</span>
                    <span>Homepage</span>
                </a>

                <a href="{{ route('home') }}"
                   class="hp-menu-item {{ request()->routeIs('deck') ? 'hp-menu-item' : '' }}">
                    <span class="hp-menu-item-icon">🐉</span>
                    <span>I miei deck</span>
                </a>

                <a href="{{ route('deck.builder') }}"
                   class="hp-menu-item {{ request()->routeIs('deck.builder') ? 'hp-menu-item--active' : '' }}">
                    <span class="hp-menu-item-icon">🧱</span>
                    <span>Crea deck</span>
                </a>

                <a href="{{ route('favorites') }}"
                   class="hp-menu-item {{ request()->routeIs('favorites') ? 'hp-menu-item--active' : '' }}">
                    <span class="hp-menu-item-icon">⭐</span>
                    <span>Deck preferiti</span>
                </a>
            </nav>
        </aside>

        {{-- CONTENUTO PRINCIPALE --}}
        <main class="hp-main">
            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>