<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PetsController extends Controller
{

    public function index(): View
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
            'findByStatus' => 'available'
        ]);

        $data = $response->json();

        if ($response->successful()) {
            return view('welcome', [
                'pets' => $data
            ]);
        }

        return view('welcome', [
            'pets' => []
        ]);
    }
}