<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Client::where('company_id', $request->user()->company_id)->get()
        );
    }

    public function store(Request $request)
    {
        $client = Client::create([
            'name' => $request->input('name'),
            'company_id' => $request->user()->company_id,
        ]);

        return response()->json($client, 201);
    }

    public function destroy(Request $request, Client $client)
    {
        $client->delete();

        return response()->noContent();
    }
}
