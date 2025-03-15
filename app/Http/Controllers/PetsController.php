<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class PetsController extends Controller
{

    public function index(Request $request): View
    {
        $page = $request->get('page', 1);
        $perPage = 10;
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus?', [
            'status' => 'available'
        ]);

        $data = $response->json();
        $data = array_map(function ($pet) {
            $pet['category'] = $pet['category'] ?? ['name' => 'brak'];
            $pet['name'] = $pet['name'] ?? 'brak';
            $pet['photoUrls'] = $pet['photoUrls'] ?? 'brak';
            return $pet;
        }, $data);
    
        $total = count($data);
        $offset = ($page - 1) * $perPage;
        $items = array_slice($data, $offset, $perPage);

        $paginator = new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('welcome', [
            'pets' => $paginator
        ]);
    }
}