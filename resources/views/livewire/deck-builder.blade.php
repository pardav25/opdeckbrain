<div class="db-layout">
    {{-- COLONNA SINISTRA: FILTRI + LISTA CARTE --}}
    <section class="db-panel">
        <div class="db-panel-header">
            <div>
                <h2 class="db-panel-title">Carte disponibili</h2>
                <p class="db-panel-caption">
                    Filtra per nome e costo, poi aggiungi al deck con il pulsante <strong>+</strong>.
                </p>
            </div>
        </div>

        {{-- FILTRI --}}
        <div class="db-filters">
            <div>
                <label class="db-label">Ricerca per nome</label>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Es. Perona, Luffy..."
                    class="db-input"
                >
            </div>

            <div class="db-filters-row">
                <div>
                    <label class="db-label">Costo minimo</label>
                    <input
                        type="number"
                        min="0"
                        wire:model.live="costMin"
                        class="db-input-number"
                    >
                </div>
                <div>
                    <label class="db-label">Costo massimo</label>
                    <input
                        type="number"
                        min="0"
                        wire:model.live="costMax"
                        class="db-input-number"
                    >
                </div>
            </div>
            <div>
                <label class="db-label">Colore</label>

                <div style="display:flex; flex-wrap:wrap; gap:0.4rem;">

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedColors" value="Red">
                        <span style="color:#ef4444;">Red</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedColors" value="Blue">
                        <span style="color:#60a5fa;">Blue</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedColors" value="Green">
                        <span style="color:#4ade80;">Green</span>
                    </label>

                     <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedColors" value="Purple">
                        <span style="color:#a855f7;">Purple</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedColors" value="Black">
                        <span style="color:#6b7280;">Black</span>
                    </label>

                   <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedColors" value="Yellow">
                        <span style="color:#facc15;">Yellow</span>
                    </label>

                </div>
            </div>
            <div>
                <label class="db-label">Tipo di carta</label>

                <div style="display:flex; flex-wrap:wrap; gap:0.4rem;">

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedTypes" value="Character">
                        <span>Character</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedTypes" value="Event">
                        <span>Event</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedTypes" value="Stage">
                        <span>Stage</span>
                    </label>
                </div>
            </div>
            <div>
                <label class="db-label">Ordina per</label>

                <div class="db-filters-row">
                    <select
                        wire:model.live="sortField"
                        class="db-input"
                    >
                        <option value="cost">Costo</option>
                        <option value="color">Colore</option>
                        <option value="power">Potenza</option>
                    </select>

                    <button
                        type="button"
                        wire:click="toggleSortDirection"
                        class="db-btn db-btn-primary"
                        style="width: 90px;"
                    >
                        @if ($sortDirection === 'asc')
                            ↑ asc
                        @else
                            ↓ desc
                        @endif
                    </button>
                </div>
            </div>
        </div>

        {{-- LISTA CARTE --}}
        @if (count($filteredCards) === 0)
            <p class="db-deck-empty">Nessuna carta trovata con questi filtri.</p>
        @else
            <ul class="db-card-list">
                @foreach ($filteredCards as $card)
                    <li class="db-card-row">
                        <div class="db-card-main">
                            <div class="db-card-name">
                                {{ $card['name'] }} <span style="color: var(--muted); font-size: 0.75rem;">({{ $card['id'] }})</span>
                            </div>
                            <div class="db-card-meta">
                                <span>Costo {{ $card['cost'] }}</span>
                                @if (!empty($card['power']))
                                    <span>Power {{ $card['power'] }}</span>
                                @endif
                                @if (!empty($card['color']))
                                    <span>{{ $card['color'] }}</span>
                                @endif
                                @if (!empty($card['type']))
                                    <span>{{ $card['type'] }}</span>
                                @endif
                            </div>
                        </div>
                        <button
                            wire:click="addCard('{{ $card['id'] }}')"
                            class="db-btn db-btn-primary"
                        >
                            +
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    {{-- COLONNA DESTRA: DECK + STATISTICHE --}}
    <section class="db-panel">
        <div class="db-panel-header">
            <div>
                <h2 class="db-panel-title">Deck: {{ $deckName }}</h2>
                <p class="db-panel-caption">
                    Aggiungi carte dal pannello a sinistra e osserva come cambiano le statistiche.
                </p>
            </div>
        </div>

        {{-- STATISTICHE --}}
        <div class="db-stats">
            <div class="db-stats-row">
                <span>Totale carte</span>
                <span><strong>{{ $stats['totalCards'] }}</strong></span>
            </div>
            <div class="db-stats-row">
                <span>Costo medio</span>
                <span><strong>{{ $stats['avgCost'] }}</strong></span>
            </div>
            <div>
    <span class="db-label">Curva dei costi</span>
    @if (empty($stats['curve']))
        <p class="db-deck-empty">Aggiungi qualche carta per vedere la curva.</p>
    @else
        @php
            $maxQty = max($stats['curve']);
        @endphp

        <div class="db-curve-chart">
            @foreach ($stats['curve'] as $cost => $qty)
                @php
                    $percent = $maxQty > 0 ? ($qty / $maxQty) * 100 : 0;
                @endphp
                <div class="db-curve-row">
                    <div class="db-curve-cost">C{{ $cost }}</div>
                    <div class="db-curve-bar-track">
                        <div class="db-curve-bar-fill" style="width: {{ $percent }}%;"></div>
                    </div>
                    <div class="db-curve-qty">{{ $qty }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
        </div>

        {{-- DECK LIST --}}
        <div class="db-deck-box">
            @if (empty($deck))
                <p class="db-deck-empty">
                    Nessuna carta nel deck. Usa il pulsante <strong>+</strong> sulle carte per aggiungerle.
                </p>
            @else
                <ul class="db-deck-list">
                    @foreach ($deck as $cardId => $entry)
                        <li class="db-deck-row">
                            <div>
                                <div class="db-card-name">
                                    {{ $entry['info']['name'] }}
                                    <span style="color: var(--muted); font-size: 0.75rem;">({{ $entry['info']['id'] }})</span>
                                </div>
                                <div class="db-deck-meta">
                                    Costo {{ $entry['info']['cost'] }} · Q.tà: {{ $entry['quantity'] }}
                                </div>
                            </div>
                            <div class="db-deck-actions">
                                <button
                                    wire:click="removeCard('{{ $cardId }}')"
                                    class="db-btn db-btn-danger"
                                >
                                    –
                                </button>
                                <button
                                    wire:click="addCard('{{ $cardId }}')"
                                    class="db-btn db-btn-primary"
                                >
                                    +
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
</div>