<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class DeckBuilder extends Component
{
    public string $deckName = 'Nuovo Deck';
    public array $cards = [];
    public array $deck = [];
    public array $selectedColors = [];
    public array $selectedTypes = [];
    public array $selectedCounters = [];
    public array $selectedAttributes = [];
    public string $search = '';
    public string $textSearch = '';
    public ?int $costMin = null;
    public ?int $costMax = null;
    public string $sortField = 'cost'; // cost | color | power
    public string $sortDirection = 'asc';
    public ?string $activeImage = null;
    public ?string $activeImageTitle = null;

    public function mount(): void
    {
        // Dati di esempio, simulano il formato "normalizzato" delle carte
        $this->cards = [
            [
                'id'    => 'OP01-077',
                'name'  => 'Perona',
                'cost'  => 1,
                'power' => 2000,
                'color' => 'Blue',
                'type'  => 'Character',
                'text' => '[On Play] Look at 5 cards from the top of your deck and place them at the top or bottom of the deck in any order.',
                'sub_types' => 'Thriller Bark Pirates',
                'counter_amount' => 1000,
                'image' => 'https://www.optcgapi.com/media/static/Card_Images/OP01-077.jpg',
                'attribute' => 'Special',
            ],
            [
                'id'    => 'OP01-015',
                'name'  => 'Tony Tony.Chopper',
                'cost'  => 3,
                'power' => 4000,
                'color' => 'Red',
                'type'  => 'Character',
                'text' => '[DON!! x1] [When Attacking] You may trash 1 card from your hand: Add up to 1 "Straw Hat Crew" type Character card other than [Tony Tony.Chopper] with a cost of 4 or less from your trash to your hand.',
                'sub_types' => 'Animal Straw Hat Crew',
                'counter_amount' => 2000,
                'image' => 'https://www.optcgapi.com/media/static/Card_Images/OP01-015.jpg',
                'attribute' => 'Slash',
            ],
            [
                'id'    => 'OP01-001',
                'name'  => 'Monkey D. Luffy',
                'cost'  => 4,
                'power' => 5000,
                'color' => 'Red',
                'type'  => 'Character',
                'text' => 'testo di prova',
                'sub_types' => 'Straw Hat Crew',
                'counter_amount' => 0,
                'image' => 'https://www.optcgapi.com/media/static/Card_Images/OP01-015.jpg',
                'attribute' => 'Strike',
            ],
        ];
    }

    public function resetFilters(): void
    {
        $this->search         = '';
        $this->textSearch     = '';
        $this->costMin        = null;
        $this->costMax        = null;
        $this->selectedColors = [];
        $this->selectedTypes  = [];
        $this->sortField      = 'cost';
        $this->sortDirection  = 'asc';
        $this->selectedCounters = [];
    }

    #[Computed]
    public function filteredCards(): array
    {
        $selectedColorsLower = array_map('strtolower', $this->selectedColors);
        $selectedTypesLower  = array_map('strtolower', $this->selectedTypes);
        $selectedCountersInt = array_map('intval', $this->selectedCounters);

        $collection = collect($this->cards)
            ->filter(function (array $card) use ($selectedColorsLower, $selectedTypesLower, $selectedCountersInt) {
                // filtro nome
                if ($this->search !== '' &&
                    stripos($card['name'], $this->search) === false) {
                    return false;
                }

                // filtro su testo (card_text) e sottotipi (sub_types)
                if ($this->textSearch !== '') {
                    $needle = $this->textSearch;

                    // unisco testo + sottotipi in una sola stringa da cercare
                    $haystack = ($card['text'] ?? '') . ' ' . ($card['sub_types'] ?? '');

                    if (stripos($haystack, $needle) === false) {
                        return false;
                    }
                }

                // filtro costo minimo
                if ($this->costMin !== null &&
                    $this->costMin !== '' &&
                    $card['cost'] < $this->costMin) {
                    return false;
                }

                // filtro costo massimo
                if ($this->costMax !== null &&
                    $this->costMax !== '' &&
                    $card['cost'] > $this->costMax) {
                    return false;
                }

                // filtro colori (multi)
                if (!empty($selectedColorsLower)) {
                    if (!in_array(strtolower($card['color'] ?? ''), $selectedColorsLower, true)) {
                        return false;
                    }
                }

                // filtro tipologia (multi)
                if (!empty($selectedTypesLower)) {
                    if (!in_array(strtolower($card['type'] ?? ''), $selectedTypesLower, true)) {
                        return false;
                    }
                }

                // filtro counter (solo Character)
                if (!empty($selectedCountersInt)) {
                    // se non è Character → esclusa
                    if (strtolower($card['type'] ?? '') !== 'character') {
                        return false;
                    }

                    $cardCounter = isset($card['counter_amount'])
                        ? (int)$card['counter_amount']
                        : 0;

                    if (!in_array($cardCounter, $selectedCountersInt, true)) {
                        return false;
                    }
                }

                if (!empty($this->selectedAttributes)) {
                    $cardAttribute = strtolower($card['attribute'] ?? '');

                    // Se la carta non ha attributo, viene esclusa
                    if (!in_array($cardAttribute, array_map('strtolower', $this->selectedAttributes))) {
                        return false;
                    }
                }

                return true;
            });

        // ORDINAMENTO
        $directionDesc = $this->sortDirection === 'desc';

        $collection = $collection->sortBy(function (array $card) {
            switch ($this->sortField) {
                case 'color':
                    return strtolower($card['color'] ?? '');
                case 'power':
                    return $card['power'] ?? 0;
                case 'cost':
                default:
                    return $card['cost'] ?? 0;
            }
        }, SORT_REGULAR, $directionDesc);

        return $collection->values()->all();
    }

    #[Computed]
    public function activeFiltersCount(): int
    {
        $count = 0;

        if ($this->search !== '') $count++;
        if ($this->costMin !== null && $this->costMin !== '') $count++;
        if ($this->costMax !== null && $this->costMax !== '') $count++;
        if (!empty($this->selectedColors)) $count++;
        if (!empty($this->selectedTypes)) $count++;
        if (!empty($this->selectedCounters)) $count++;
        if (!empty($this->selectedAttributes)) $count++;
        if ($this->textSearch !== '') $count++;

        return $count;
    }

    #[Computed]
    public function stats(): array
    {
        $totalCards = 0;
        $totalCost  = 0;
        $curve      = [];

        // 🛡️ Statistiche counter nel deck
        // chiavi come stringhe per comodità in Blade
        $counterStats = [
            '0'    => 0,
            '1000' => 0,
            '2000' => 0,
        ];

        foreach ($this->deck as $entry) {
            $qty  = $entry['quantity'];
            $info = $entry['info'];

            $cost = $info['cost'] ?? 0;

            $totalCards += $qty;
            $totalCost  += $cost * $qty;

            // curva dei costi
            if (!isset($curve[$cost])) {
                $curve[$cost] = 0;
            }
            $curve[$cost] += $qty;

            // conteggio counter (0 / 1000 / 2000)
            $cardCounter = isset($info['counter_amount'])
                ? (int) $info['counter_amount']
                : 0;

            $key = (string) $cardCounter;

            if (array_key_exists($key, $counterStats)) {
                $counterStats[$key] += $qty;
            } else {
                // se mai arrivasse un valore diverso, puoi decidere di ignorarlo
                // oppure aggiungere una categoria "altro"
            }
        }

        ksort($curve);

        return [
            'totalCards' => $totalCards,
            'avgCost'    => $totalCards > 0
                ? round($totalCost / $totalCards, 2)
                : 0,
            'curve'      => $curve,
            'counters'   => $counterStats,
        ];
    }

    #[Computed]
    public function deckValidation(): array
    {
        $total = $this->stats['totalCards'] ?? 0;

        if ($total < 50) {
            return [
                'status' => 'error',
                'message' => 'Il deck contiene solo ' . $total . ' carte. Ne servono esattamente 50.',
            ];
        }

        if ($total > 50) {
            return [
                'status' => 'error',
                'message' => 'Il deck contiene ' . $total . ' carte. Ne servono esattamente 50.',
            ];
        }

        return [
            'status' => 'ok',
            'message' => 'Il deck contiene 50 carte (formato valido).',
        ];
    }

    public function addCard(string $cardId): void
    {
        if (!isset($this->deck[$cardId])) {
            $card = collect($this->cards)->firstWhere('id', $cardId);

            if ($card) {
                $this->deck[$cardId] = [
                    'info'     => $card,
                    'quantity' => 1,
                ];
            }
        } else {
            $this->deck[$cardId]['quantity']++;
        }
    }

    public function addFourCards(string $cardId): void
    {
        $card = collect($this->cards)->firstWhere('id', $cardId);

        if (!$card) {
            return;
        }

        // numero massimo copie concesse (standard OP è 4)
        $maxCopies = 4;

        if (!isset($this->deck[$cardId])) {
            // aggiunge 4 copie se la carta non esiste nel deck
            $this->deck[$cardId] = [
                'info'     => $card,
                'quantity' => $maxCopies,
            ];
        } else {
            // aggiunge copie fino a massimo 4
            $current = $this->deck[$cardId]['quantity'];
            $newQty  = min($current + $maxCopies, $maxCopies);

            $this->deck[$cardId]['quantity'] = $newQty;
        }
    }

    public function removeCard(string $cardId): void
    {
        if (!isset($this->deck[$cardId])) {
            return;
        }

        $this->deck[$cardId]['quantity']--;

        if ($this->deck[$cardId]['quantity'] <= 0) {
            unset($this->deck[$cardId]);
        }
    }

    public function removeAllCopies(string $cardId): void
    {
        if (isset($this->deck[$cardId])) {
            unset($this->deck[$cardId]);
        }
    }

    public function render()
    {
        return view('livewire.deck-builder', [
            'filteredCards' => $this->filteredCards,
            'stats'         => $this->stats,
            'totalCards'    => count($this->cards),
            'activeFiltersCount' => $this->activeFiltersCount,
            'counter_amount' => $card['counter_amount'] ?? 0,
            'text'      => $card['card_text'] ?? null,
            'sub_types' => $card['sub_types'] ?? null,
            'deckValidation'     => $this->deckValidation,
        ]);
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function showImage(?string $url, ?string $title = null): void
    {
        if (!$url) {
            return;
        }

        $this->activeImage = $url;
        $this->activeImageTitle = $title;
    }

    public function closeImage(): void
    {
        $this->activeImage = null;
        $this->activeImageTitle = null;
    }
}