<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RickAndMortyController extends Controller
{
    public function getCharacters()
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false, // Desactiva la verificación SSL
        ]);

        $response = $client->get('https://rickandmortyapi.com/api/character');
        $characters = json_decode($response->getBody()->getContents());

        return view('rickandmorty.characters', ['characters' => $characters->results]);
    }
}
