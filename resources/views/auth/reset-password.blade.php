<x-guest-layout>
    <x-slot name="title">
        Reimposta password
    </x-slot>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token di reset -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="guest-input-group">
            <label for="email" class="guest-label">
                Email
            </label>

            <input id="email"
                   class="guest-input"
                   type="email"
                   name="email"
                   value="{{ old('email', $request->email) }}"
                   required
                   autofocus
            >

            @error('email')
                <div class="guest-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nuova password --}}
        <div class="guest-input-group">
            <label for="password" class="guest-label">
                Nuova password
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

        <div class="guest-actions">
            <button type="submit" class="db-btn db-btn-primary" style="width: 100%;">
                Salva nuova password
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