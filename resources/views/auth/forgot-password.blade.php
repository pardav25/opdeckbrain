<x-guest-layout>
    <x-slot name="title">
        Password dimenticata
    </x-slot>

    {{-- Messaggio di stato (es. email inviata) --}}
    <x-auth-session-status class="guest-error" :status="session('status')" />

    <p class="guest-description">
        Hai dimenticato la password? Nessun problema.
        Inserisci il tuo indirizzo email e ti invieremo un link per reimpostarla
        e scegliere una nuova password.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
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
            >

            @error('email')
                <div class="guest-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="guest-actions">
            <button type="submit" class="db-btn db-btn-primary" style="width: 100%;">
                Invia link per il reset
            </button>
        </div>
    </form>

    <div class="guest-footer">
        @if (Route::has('login'))
            <a href="{{ route('login') }}" class="guest-link">
                Torna al login
            </a>
        @endif
    </div>
</x-guest-layout>