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
    public string $search = '';
    public ?int $costMin = null;
    public ?int $costMax = null;
    public string $sortField = 'cost'; // cost | color | power
    public string $sortDirection = 'asc';

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
            ],
            [
                'id'    => 'OP01-015',
                'name'  => 'Tony Tony.Chopper',
                'cost'  => 3,
                'power' => 4000,
                'color' => 'Red',
                'type'  => 'Character',
            ],
            [
                'id'    => 'OP01-001',
                'name'  => 'Monkey D. Luffy',
                'cost'  => 4,
                'power' => 5000,
                'color' => 'Red',
                'type'  => 'Character',
            ],
        ];
    }

    #[Computed]
    public function filteredCards(): array
    {
        $collection = collect($this->cards)
            ->filter(function (array $card) {
                // filtro nome
                if ($this->search !== '' &&
                    stripos($card['name'], $this->search) === false) {
                    return false;
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
                if (!empty($this->selectedColors)) {
                    if (!in_array(
                        strtolower($card['color']),
                        array_map('strtolower', $this->selectedColors)
                    )) {
                        return false;
                    }
                }

                // filtro tipologia (multi)
                if (!empty($this->selectedTypes)) {
                    if (!in_array(
                        strtolower($card['type']),
                        array_map('strtolower', $this->selectedTypes)
                    )) {
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
    public function stats(): array
    {
        $totalCards = 0;
        $totalCost  = 0;
        $curve      = [];

        foreach ($this->deck as $entry) {
            $qty  = $entry['quantity'];
            $cost = $entry['info']['cost'] ?? 0;

            $totalCards += $qty;
            $totalCost  += $cost * $qty;

            if (!isset($curve[$cost])) {
                $curve[$cost] = 0;
            }
            $curve[$cost] += $qty;
        }

        ksort($curve);

        return [
            'totalCards' => $totalCards,
            'avgCost'    => $totalCards > 0
                ? round($totalCost / $totalCards, 2)
                : 0,
            'curve'      => $curve,
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

    public function render()
    {
        return view('livewire.deck-builder', [
            'filteredCards' => $this->filteredCards,
            'stats'         => $this->stats,
        ]);
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
}