<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Quote::where('company_id', $request->user()->company_id)->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'number' => ['required', 'string'],
            'currency' => ['required', 'string', 'size:3'],
            'status' => ['required', 'string'],
            'public_hash' => ['required', 'string'],
        ]);

        $data['company_id'] = $request->user()->company_id;

        $quote = Quote::create($data);

        return response()->json($quote, 201);
    }

    public function destroy(Request $request, Quote $quote)
    {
        $quote->delete();

        return response()->noContent();
    }
}
