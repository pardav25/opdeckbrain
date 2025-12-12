<div style="display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap; font-family: system-ui, sans-serif;">
    {{-- COLONNA SINISTRA: FILTRI + LISTA CARTE --}}
    <div style="flex: 1; min-width: 280px;">
        <h2 style="margin-bottom: 0.5rem;">Carte disponibili</h2>

        {{-- FILTRI --}}
        <div style="margin-bottom: 1rem; padding: 0.75rem; border: 1px solid #444; border-radius: 8px;">
            <div style="margin-bottom: 0.5rem;">
                <label>Ricerca per nome</label><br>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Es. Luffy"
                    style="width: 100%; padding: 0.4rem; border-radius: 4px; border: 1px solid #666; background:#111; color:#eee;"
                >
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <div style="flex: 1;">
                    <label>Costo min</label><br>
                    <input
                        type="number"
                        min="0"
                        wire:model.live="costMin"
                        style="width: 100%; padding: 0.3rem; border-radius: 4px; border: 1px solid #666; background:#111; color:#eee;"
                    >
                </div>
                <div style="flex: 1;">
                    <label>Costo max</label><br>
                    <input
                        type="number"
                        min="0"
                        wire:model.live="costMax"
                        style="width: 100%; padding: 0.3rem; border-radius: 4px; border: 1px solid #666; background:#111; color:#eee;"
                    >
                </div>
            </div>
        </div>

        {{-- LISTA CARTE FILTRATE --}}
        @if (count($filteredCards) === 0)
            <p>Nessuna carta trovata con questi filtri.</p>
        @else
            <ul style="list-style: none; padding-left: 0; max-height: 400px; overflow-y: auto; border: 1px solid #333; border-radius: 8px;">
                @foreach ($filteredCards as $card)
                    <li style="padding: 0.5rem 0.75rem; border-bottom: 1px solid #222; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <strong>{{ $card['name'] }}</strong>
                            <div style="font-size: 0.85rem; color:#aaa;">
                                Costo: {{ $card['cost'] }} | Colore: {{ $card['color'] }}
                            </div>
                        </div>
                        <button
                            wire:click="addCard({{ $card['id'] }})"
                            style="padding: 0.25rem 0.6rem; border-radius: 4px; border: none; background:#2dd4bf; color:#000; cursor:pointer;"
                        >
                            +
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- COLONNA DESTRA: DECK + STATISTICHE --}}
    <div style="flex: 1; min-width: 280px;">
        <h2 style="margin-bottom: 0.5rem;">Deck: {{ $deckName }}</h2>

        {{-- STATISTICHE --}}
        <div style="margin-bottom: 1rem; padding: 0.75rem; border: 1px solid #444; border-radius: 8px;">
            <h3 style="margin-top:0; margin-bottom:0.5rem; font-size:1rem;">Statistiche deck</h3>
            <p style="margin:0.2rem 0;">Totale carte: <strong>{{ $stats['totalCards'] }}</strong></p>
            <p style="margin:0.2rem 0;">Costo medio: <strong>{{ $stats['avgCost'] }}</strong></p>

            <div style="margin-top:0.5rem;">
                <strong>Curva costi:</strong>
                @if (empty($stats['curve']))
                    <span> nessuna carta ancora.</span>
                @else
                    <ul style="list-style:none; padding-left:0; margin:0.25rem 0 0;">
                        @foreach ($stats['curve'] as $cost => $qty)
                            <li style="font-size:0.85rem;">
                                Costo {{ $cost }} → {{ $qty }} carta/e
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- LISTA CARTE NEL DECK --}}
        <div style="border: 1px solid #333; border-radius: 8px; padding:0.75rem;">
            @if (empty($deck))
                <p>Nessuna carta nel deck.</p>
            @else
                <ul style="list-style:none; padding-left:0;">
                    @foreach ($deck as $cardId => $entry)
                        <li style="margin-bottom: 0.5rem; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <strong>{{ $entry['info']['name'] }}</strong>
                                <div style="font-size:0.85rem; color:#aaa;">
                                    Costo {{ $entry['info']['cost'] }} | Q.tà: {{ $entry['quantity'] }}
                                </div>
                            </div>
                            <div>
                                <button
                                    wire:click="removeCard({{ $cardId }})"
                                    style="padding: 0.2rem 0.5rem; border-radius: 4px; border:none; background:#ef4444; color:#fff; cursor:pointer; margin-right:0.25rem;"
                                >-</button>
                                <button
                                    wire:click="addCard({{ $cardId }})"
                                    style="padding: 0.2rem 0.5rem; border-radius: 4px; border:none; background:#22c55e; color:#000; cursor:pointer;"
                                >+</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>