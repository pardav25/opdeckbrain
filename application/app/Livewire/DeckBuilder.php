<?php

namespace App\Livewire;

use Livewire\Component;

class DeckBuilder extends Component
{
    public $deckName = 'Nuovo Deck';

    // dati grezzi (per ora finti, poi li prenderemo dal DB)
    public $cards = [];

    // stato del deck: [cardId => ['info' => [...], 'quantity' => int]]
    public $deck = [];

    // filtri
    public $search = '';
    public $costMin = null;
    public $costMax = null;

    public function mount()
    {
        // Per ora simuliamo qualche carta finta
        $this->cards = [
            ['id' => 1, 'name' => 'Luffy', 'cost' => 3, 'color' => 'RED'],
            ['id' => 2, 'name' => 'Zoro',  'cost' => 2, 'color' => 'GREEN'],
            ['id' => 3, 'name' => 'Nami',  'cost' => 1, 'color' => 'BLUE'],
            ['id' => 4, 'name' => 'Sanji', 'cost' => 4, 'color' => 'YELLOW'],
            ['id' => 5, 'name' => 'Usopp', 'cost' => 2, 'color' => 'RED'],
        ];
    }

    public function addCard($cardId)
    {
        if (!isset($this->deck[$cardId])) {
            $card = collect($this->cards)->firstWhere('id', $cardId);
            if ($card) {
                $this->deck[$cardId] = [
                    'info' => $card,
                    'quantity' => 1,
                ];
            }
        } else {
            $this->deck[$cardId]['quantity']++;
        }
    }

    public function removeCard($cardId)
    {
        if (isset($this->deck[$cardId])) {
            $this->deck[$cardId]['quantity']--;
            if ($this->deck[$cardId]['quantity'] <= 0) {
                unset($this->deck[$cardId]);
            }
        }
    }

    protected function getFilteredCards()
    {
        return collect($this->cards)
            ->filter(function ($card) {
                // filtro per nome
                if ($this->search !== '' &&
                    stripos($card['name'], $this->search) === false) {
                    return false;
                }

                // filtro per costo minimo
                if ($this->costMin !== null && $this->costMin !== '' &&
                    $card['cost'] < $this->costMin) {
                    return false;
                }

                // filtro per costo massimo
                if ($this->costMax !== null && $this->costMax !== '' &&
                    $card['cost'] > $this->costMax) {
                    return false;
                }

                return true;
            })
            ->values()
            ->all();
    }

    protected function getDeckStats()
    {
        $totalCards = 0;
        $totalCost = 0;
        $curve = []; // cost => quantity

        foreach ($this->deck as $entry) {
            $qty = $entry['quantity'];
            $cost = $entry['info']['cost'];

            $totalCards += $qty;
            $totalCost += $cost * $qty;

            if (!isset($curve[$cost])) {
                $curve[$cost] = 0;
            }
            $curve[$cost] += $qty;
        }

        ksort($curve);

        return [
            'totalCards' => $totalCards,
            'avgCost'    => $totalCards > 0 ? round($totalCost / $totalCards, 2) : 0,
            'curve'      => $curve,
        ];
    }

    public function render()
    {
        $filteredCards = $this->getFilteredCards();
        $stats = $this->getDeckStats();

        return view('livewire.deck-builder', [
            'filteredCards' => $filteredCards,
            'stats'         => $stats,
        ]);
    }
}