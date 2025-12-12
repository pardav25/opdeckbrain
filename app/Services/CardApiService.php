<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CardApiService
{
    public function fetchCards(?string $search = null): array
    {
        $baseUrl = config('services.cards_api.base_url'); // es: https://www.optcgapi.com/...
        
        $query = [];

        if ($search) {
            // adatta il nome del parametro a quello reale dell’API
            $query['card_name'] = $search;
        }

        $response = Http::get($baseUrl . '/allSetCards', $query);

        if ($response->failed()) {
            // volendo puoi fare log o lanciare un'eccezione
            return [];
        }

        // nel tuo esempio la risposta è un array "nudo", non dentro data[]
        $rawCards = $response->json();

        // Mappiamo i campi esterni in un formato interno standard
        return collect($rawCards)->map(function ($card) {
            return [
                'id'      => $card['card_set_id'] ?? null,
                'name'    => $card['card_name'] ?? '',
                'cost'    => isset($card['card_cost']) ? (int) $card['card_cost'] : 0,
                'color'   => $card['card_color'] ?? null,
                'type'    => $card['card_type'] ?? null,
                'power'   => isset($card['card_power']) ? (int) $card['card_power'] : null,
                'text'    => $card['card_text'] ?? null,
                'rarity'  => $card['rarity'] ?? null,
                'image'   => $card['card_image'] ?? null,
                'price'   => $card['market_price'] ?? null,
                'raw'     => $card, // original JSON
            ];
        })->filter(fn ($c) => !empty($c['id']))
          ->values()
          ->all();
    }
}