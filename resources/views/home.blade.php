@extends('layouts.app-shell')

@section('content')
    <div class="hp-main-header">
        <h1 class="hp-main-title">Deck pubblici della community</h1>
        <p class="hp-main-subtitle">
            Esplora i deck creati dagli altri utenti, prendi ispirazione e testa nuove idee.
        </p>
    </div>

    @if ($decks->isEmpty())
        <p class="hp-empty">
            Nessun deck pubblicato al momento. Sarai il primo a condividere il tuo!
        </p>
    @else
        <div class="hp-decks-grid">
            @foreach ($decks as $deck)
                <article class="hp-deck-card">
                    <div class="hp-deck-header">
                        <h2 class="hp-deck-name">
                            {{ $deck->name }}
                        </h2>
                        @if (!empty($deck->leader_colors))
                            <div class="hp-deck-colors">
                                @foreach ($deck->leader_colors as $color)
                                    @php $slug = strtolower($color); @endphp
                                    <span class="hp-color-badge hp-color-badge--{{ $slug }}">
                                        {{ $color }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <p class="hp-deck-meta">
                        Leader:
                        <span class="hp-deck-meta-strong">{{ $deck->leader_id ?? 'N/D' }}</span><br>
                        Carte: {{ collect($deck->cards)->sum('quantity') ?? 0 }}
                    </p>

                    <div class="hp-deck-footer">
                        <button type="button" class="hp-btn hp-btn-ghost-small">
                            Dettagli
                        </button>
                        <button type="button" class="hp-btn hp-btn-primary-small">
                            Importa nel builder
                        </button>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="hp-pagination">
            {{ $decks->links() }}
        </div>
    @endif
@endsection