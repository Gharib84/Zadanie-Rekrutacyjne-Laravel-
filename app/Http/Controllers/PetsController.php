<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class PetsController extends Controller
{
    public function index(Request $request)
    {
        $statusValue = $request->input('status', 'available');
        $page = $request->get('page', 1);
        $perPage = 10;

        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
            'status' => $statusValue
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

        if ($request->isMethod('post')) {
            return response()->json(['pets' => $paginator]);
        }

        return view('welcome', [
            'pets' => $paginator
        ]);
    }

    public function store(Request $request)
    {
        $petData = [
            'name' => $request->input('name'),
            'category' => ['name' => $request->input('category')],
            'photoUrls' => explode(',', $request->input('photoUrls')),
            'tags' => array_map(function ($tag) {
                return ['name' => trim($tag)];
            }, explode(',', $request->input('tags'))),
            'status' => $request->input('status')
        ];
        
        $response = Http::post('https://petstore.swagger.io/v2/pet', $petData);

        if ($response->successful()) {
            return Redirect::route('pets.index')->with('success', 'Pet created successfully');
        }

        return Redirect::route('pets.index')->with('error', 'Failed to create pet');
    }

    //edit
    public function edit($id)
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/' . $id);

        if ($response->successful()) {
            return response()->json(['pet' => $response->json()]);
        }

        return response()->json(['error' => 'Failed to fetch pet'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }   

    //delete
    public function destroy($id)
    {
        $response = Http::delete('https://petstore.swagger.io/v2/pet/' . $id);

        if ($response->successful()) {
            return Redirect::route('pets.index')->with('success', 'Pet deleted successfully');
        }

        return Redirect::route('pets.index')->with('error', 'Failed to delete pet');
    }
}