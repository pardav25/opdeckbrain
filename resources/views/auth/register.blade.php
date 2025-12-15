<x-guest-layout>
    <x-slot name="title">
        Registrati
    </x-slot>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nickname --}}
        <div class="guest-input-group">
            <label for="name" class="guest-label">
                Nickname
            </label>

            <input id="name"
                   class="guest-input"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   autocomplete="name"
            >

            @error('name')
                <div class="guest-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="guest-input-group">
            <label for="email" class="guest-label">
                Email
            </label>

            <input id="email"
                   class="guest-input"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="username"
            >

            @error('email')
                <div class="guest-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="guest-input-group">
            <label for="password" class="guest-label">
                Password
            </label>

            <input id="password"
                   class="guest-input"
                   type="password"
                   name="password"
                   required
                   autocomplete="new-password"
            >

            @error('password')
                <div class="guest-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Conferma password --}}
        <div class="guest-input-group">
            <label for="password_confirmation" class="guest-label">
                Conferma password
            </label>

            <input id="password_confirmation"
                   class="guest-input"
                   type="password"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
            >
        </div>

        {{-- Pulsante registrati --}}
        <div style="margin-top:0.5rem;">
            <button type="submit" class="guest-btn guest-btn-primary">
                Crea account
            </button>
        </div>
    </form>

    {{-- Footer: link a login --}}
    <div class="guest-footer">
        <span class="guest-text-muted">
            Hai già un account?
        </span>
        <br>
        @if (Route::has('login'))
            <a href="{{ route('login') }}" class="guest-link">
                Vai al login
            </a>
        @endif
    </div>
</x-guest-layout>