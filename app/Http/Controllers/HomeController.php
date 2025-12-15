<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Per ora prendiamo tutti i deck, in futuro potrai filtrare solo quelli "pubblici"
        //$decks = Deck::latest()->paginate(12);
        $decks = collect([]);


        return view('home', [
            'decks' => $decks,
        ]);
    }
}