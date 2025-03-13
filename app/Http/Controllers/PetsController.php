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
            'status' => 'available',
            'page' => $page,
            'per_page' => 10
        ]);

        $data = $response->json();
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
