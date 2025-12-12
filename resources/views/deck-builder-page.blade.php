<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Zoodiac TCG – Deck Builder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/deckbuilder.css') }}">
</head>
<body>
    <div class="db-page">
        <div class="db-container">
            <header class="db-header">
                <div class="db-title-row">
                    <h1 class="db-title">One Piece TCG – Deck Builder</h1>
                    <span class="db-badge">alpha · Livewire</span>
                </div>
                <p class="db-subtitle">
                    Costruisci e analizza il tuo deck in tempo reale. Questa è una versione di test, ma è già giocabile 💀☠️
                </p>
            </header>

            @livewire('deck-builder')
        </div>
    </div>

    @livewireScripts
</body>
</html>