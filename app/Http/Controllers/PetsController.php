<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PetsController extends Controller
{

    public function index(Request $request): View
    {
        $page = $request->get('page', 1);
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus?', [
            'status' => 'pending',
            'page' => $page,
            'per_page' => 10
        ]);

        $data = $response->json();

        // Ensure all pets have a category and name key
        $data = array_map(function ($pet) {
            $pet['category'] = $pet['category'] ?? ['name' => 'brak'];
            $pet['name'] = $pet['name'] ?? 'brak';
            $pet['photoUrls'] = $pet['photoUrls'] ?? 'brak';
            
            return $pet;
        }, $data);

        $total = count($data);
        $totalPages = ceil($total / 10);

        return view('welcome', [
            'pets' => $data,
            'total' => $total,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
}