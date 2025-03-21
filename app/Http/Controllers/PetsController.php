<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function store(Request $request): JsonResponse
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
            return response()->json([
                'success' => true,
                'message' => 'Pet created successfully',
                'data' => $response->json(),
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to create pet',
        ], 500);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $response = Http::delete('https://petstore.swagger.io/v2/pet/' . $id);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Pet deleted successfully',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete pet',
        ], 500);
    }

    //edit pet 
    public function edit(Request $request, $id): JsonResponse
    {
        $petData = [
            'name' => $request->input('name'),
            'status' => $request->input('status')
        ];      

        $response = Http::post('https://petstore.swagger.io/v2/pet', $petData);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Pet updated successfully',
                'data' => $response->json(),
            ], 201);
        } 

        return response()->json([
            'success' => false,
            'message' => 'Failed to update pet',    
        ]);  
    }

}