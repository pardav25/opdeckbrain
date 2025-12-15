<x-guest-layout>
    <x-slot name="title">
        Login
    </x-slot>

    {{-- Messaggi di stato (es. password reset ok) --}}
    <x-auth-session-status class="guest-error" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
                   autofocus
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
                   autocomplete="current-password"
            >

            @error('password')
                <div class="guest-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember me + Forgot password --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; gap:0.5rem;">
            <label style="display:flex; align-items:center; gap:0.35rem; font-size:0.8rem; color:#9ca3af;">
                <input id="remember_me"
                       type="checkbox"
                       name="remember"
                       style="width:14px; height:14px; accent-color:#22c55e;">
                <span>Ricordami</span>
            </label>

            @if (Route::has('password.request'))
                <a class="guest-link" href="{{ route('password.request') }}">
                    Password dimenticata?
                </a>
            @endif
        </div>

        {{-- Pulsante login --}}
        <div>
            <button type="submit" class="guest-btn guest-btn-primary">
                Accedi
            </button>
        </div>
    </form>

    {{-- Footer: link a registrazione --}}
    <div class="guest-footer">
        <span class="guest-text-muted">
            Non hai ancora un account?
        </span>
        <br>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="guest-link">
                Registrati ora
            </a>
        @endif
    </div>
</x-guest-layout>