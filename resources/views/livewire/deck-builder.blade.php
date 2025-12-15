<div class="db-layout">
    {{-- COLONNA SINISTRA: FILTRI + LISTA CARTE --}}
    <section class="db-panel">
       <div class="db-panel-header">
            <div>
                <h2 class="db-panel-title">Carte disponibili</h2>
                <p class="db-panel-caption">
                    Filtra per nome, costo, colore e tipo, poi aggiungi al deck con il pulsante <strong>+</strong>.
                </p>
            </div>

            <div style="text-align: right; font-size: 0.75rem; display:flex; flex-direction:column; gap:0.25rem; align-items:flex-end;">

                {{-- Badge risultati --}}
                <div class="db-badge">
                    {{ count($filteredCards) }} / {{ $totalCards }} risultati
                </div>

                {{-- Badge filtri attivi (solo se > 0) --}}
                @if ($activeFiltersCount > 0)
                    <div class="db-badge" style="background: var(--accent-soft); color: var(--accent); border-color: var(--accent);">
                        Filtri attivi: {{ $activeFiltersCount }}
                    </div>
                @endif

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
            <div>
                <label class="db-label">Testo / Sottotipi</label>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="textSearch"
                    placeholder="Es. Straw Hat Crew, blocker"
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
                <label class="db-label">Attributo</label>

                <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedAttributes" value="Slash">
                        <span>Slash</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedAttributes" value="Strike">
                        <span>Strike</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedAttributes" value="Wisdom">
                        <span>Wisdom</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedAttributes" value="Ranged">
                        <span>Ranged</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedAttributes" value="Special">
                        <span>Special</span>
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

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedTypes" value="Leader">
                        <span>Leader</span>
                    </label>
                </div>
            </div>
            <div>
                <label class="db-label">Counter</label>

                <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedCounters" value="0">
                        <span>0</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedCounters" value="1000">
                        <span>1000</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:0.25rem;">
                        <input type="checkbox" wire:model.live="selectedCounters" value="2000">
                        <span>2000</span>
                    </label>

                </div>

                <p class="db-panel-caption" style="margin-top:4px;">
                    (Valido solo per carte Character)
                </p>
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
            <div style="display:flex; justify-content:flex-end; margin-top:0.25rem;">
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="db-btn"
                    style="background: transparent; border: 1px solid var(--border); color: var(--muted); padding-inline: 0.75rem;"
                >
                    Reset filtri
                </button>
            </div>
        </div>

        {{-- LISTA CARTE --}}
        @if (count($filteredCards) === 0)
            <p class="db-deck-empty">Nessuna carta trovata con questi filtri.</p>
        @else
            <ul class="db-card-list">
                @foreach ($filteredCards as $card)
                    <li class="db-card-row">
                    @if (!empty($card['image']))
                        <div
                            class="db-card-thumb-wrapper"
                            wire:click="showImage('{{ $card['image'] }}', '{{ $card['name'] }} ({{ $card['id'] }})')"
                        >
                            <img
                                src="{{ $card['image'] }}"
                                alt="{{ $card['name'] }}"
                                class="db-card-thumb"
                            >
                        </div>
                    @endif

                    <div class="db-card-main">
                        <div class="db-card-name">
                            {{ $card['name'] }}
                            <span style="color: var(--muted); font-size: 0.75rem;">({{ $card['id'] }})</span>
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

                   <div style="display:flex; gap:0.3rem;">
                        {{-- bottone Leader, solo se la carta è di tipo Leader --}}
                        @if (strtolower($card['type'] ?? '') === 'leader')
                        <button
                            wire:click="setLeader('{{ $card['id'] }}')"
                            class="db-btn"
                            title="Imposta come Leader"
                            style="
                                background: transparent;
                                border: 1px solid var(--accent);
                                color: var(--accent);
                                padding-inline: 0.5rem;
                            "
                        >
                            👑
                        </button>
                        @else
                        <button
                            wire:click="addCard('{{ $card['id'] }}')"
                            class="db-btn db-btn-primary"
                            title="Aggiungi 1 copia"
                        >
                            + 1
                        </button>

                        <button
                            wire:click="addFourCards('{{ $card['id'] }}')"
                            class="db-btn db-btn-primary"
                            title="Aggiungi 4 copie"
                            style=""
                        >
                            + 4
                        </button>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </section>

    {{-- COLONNA DESTRA: DECK + STATISTICHE --}}
    <section class="db-panel">
        <div class="db-panel-header">
            <div>
                <h2 class="db-panel-title">Deck</h2>
                <p class="db-panel-caption">
                    Aggiungi carte dal pannello a sinistra e osserva come cambiano le statistiche.
                </p>
                @if ($selectingLeader)
                    <div class="db-selecting-leader-hint">
                        Modalità scelta Leader attiva: clicca su “Leader” su una carta di tipo Leader a sinistra.
                    </div>
                @endif
            </div>

            <div class="db-deck-header-right">
                <input
                    type="text"
                    wire:model.live="deckName"
                    class="db-deckname-input"
                    placeholder="Nome del deck"
                >

                <div
                    class="db-leader-box"
                    @if($selectingLeader)
                        wire:click="cancelLeaderSelection"
                    @else
                        wire:click="startLeaderSelection"
                    @endif
                >
                    @if ($leaderCard)
                        <div class="db-leader-thumb">
                            @if (!empty($leaderCard['image']))
                                <img src="{{ $leaderCard['image'] }}" alt="{{ $leaderCard['name'] }}">
                            @endif
                        </div>
                        <div class="db-leader-labels">
                            <div class="db-leader-label-top">Leader</div>
                            <div class="db-leader-label-main">
                                {{ $leaderCard['name'] ?? '' }}
                            </div>
                        </div>
                    @else
                        <div class="db-leader-label-empty">
                            Seleziona Leader
                        </div>
                    @endif
                </div>
                <button
                    type="button"
                    wire:click="saveDeck"
                    wire:loading.attr="disabled"
                    wire:target="saveDeck"
                    class="db-btn db-btn-primary"
                    style="white-space: nowrap;"
                >
                    <span wire:loading.remove wire:target="saveDeck">
                        Salva deck
                    </span>

                    <span wire:loading wire:target="saveDeck">
                        Salvataggio…
                    </span>
                </button>
            </div>
            @if ($saveMessage)
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    x-transition.opacity.duration.300ms
                    style="
                        margin-top: 0.75rem;
                        margin-bottom: 0.25rem;
                        padding: 0.6rem 0.75rem;
                        border-radius: 0.75rem;
                        font-size: 0.85rem;
                        line-height: 1.3;
                        {{ $saveMessageType === 'success'
                            ? 'background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.4); color: #bbf7d0;'
                            : 'background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #fecaca;'
                        }}
                    "
                >
                    {{ $saveMessage }}
                </div>
            @endif
        </div>
        {{-- VALIDAZIONE DECK --}}
        @if ($deckValidation['status'] === 'error')
            <div style="
                margin-bottom: 1rem;
                padding: 0.75rem;
                border-radius: 0.75rem;
                background: rgba(239, 68, 68, 0.15);
                border: 1px solid rgba(239, 68, 68, 0.4);
                color: #fca5a5;
                font-size: 0.85rem;
                line-height: 1.3;
            ">
                ⚠️ {{ $deckValidation['message'] }}
            </div>
        @endif

        @if ($deckValidation['status'] === 'ok')
            <div style="
                margin-bottom: 1rem;
                padding: 0.75rem;
                border-radius: 0.75rem;
                background: rgba(34, 197, 94, 0.15);
                border: 1px solid rgba(34, 197, 94, 0.4);
                color: #86efac;
                font-size: 0.85rem;
                line-height: 1.3;
            ">
                ✔️ {{ $deckValidation['message'] }}
            </div>
        @endif

        {{-- STATISTICHE --}}
        <div class="db-stats">
            <div class="db-stats-row">
               <span class="db-label">Colori Leader</span>
                @if ($leaderCard && !empty($leaderColors))
                    <div class="db-color-leader-row">
                        <div class="db-color-badges">
                            @foreach ($leaderColors as $color)
                                @php $slug = strtolower($color); @endphp
                                <span class="db-color-badge db-color-badge--{{ $slug }}">
                                    {{ $color }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @elseif ($leaderCard)
                    <p class="db-panel-caption" style="margin-top: 0.15rem;">
                        Nessun colore rilevato per il Leader.
                    </p>
                @else
                    <p class="db-panel-caption" style="margin-top: 0.15rem;">
                        Nessun Leader selezionato.
                    </p>
                @endif
            </div>
            <div class="db-stats-row">
                <span>Totale carte</span>
                <span><strong>{{ $stats['totalCards'] - $stats['leaderCount'] }}</strong></span>
            </div>
            <div class="db-stats-row">
                <span>Costo medio</span>
                <span><strong>{{ $stats['avgCost'] }}</strong></span>
            </div>
            <div style="margin-top: 0.75rem;">
                <span class="db-label">Counter nel deck</span>

                @php
                    $counters = $stats['counters'] ?? ['0' => 0, '1000' => 0, '2000' => 0];
                    $maxCounter = max($counters);
                @endphp

                @if ($maxCounter === 0)
                    <p class="db-deck-empty">Nessuna carta con counter nel deck.</p>
                @else
                    <div class="db-curve-chart">
                        @foreach (['0', '1000', '2000'] as $counterValue)
                            @php
                                $qty = $counters[$counterValue] ?? 0;
                                $percent = $maxCounter > 0 ? ($qty / $maxCounter) * 100 : 0;
                            @endphp

                            <div class="db-curve-row">
                                <div class="db-curve-cost">{{ $counterValue }}</div>
                                <div class="db-curve-bar-track">
                                    <div class="db-curve-bar-fill" style="width: {{ $percent }}%;"></div>
                                </div>
                                <div class="db-curve-qty">{{ $qty }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div style="margin-top: 0.75rem;">
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
                                    – 1
                                </button>
                                <button
                                    wire:click="addCard('{{ $cardId }}')"
                                    class="db-btn db-btn-primary"
                                >
                                    + 1
                                </button>
                                <button
                                    wire:click="removeAllCopies('{{ $cardId }}')"
                                    class="db-btn"
                                    title="Rimuovi tutte le copie"
                                    style="background: transparent; border: 1px solid var(--border); color: var(--muted); padding-inline: 0.5rem;"
                                >
                                    ✕
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>

    @if ($activeImage)
    <div class="db-modal-backdrop" wire:click="closeImage">
        <div class="db-modal" wire:click.stop>
            <div class="db-modal-header">
                <div class="db-modal-title">
                    {{ $activeImageTitle ?? 'Anteprima carta' }}
                </div>
                <button
                    type="button"
                    class="db-btn db-btn-danger"
                    wire:click="closeImage"
                >
                    ✕
                </button>
            </div>

            <div class="db-modal-image-wrapper">
                <img
                    src="{{ $activeImage }}"
                    alt="{{ $activeImageTitle ?? 'Card image' }}"
                    class="db-modal-image"
                >
            </div>
        </div>
    </div>
    @endif
</div>