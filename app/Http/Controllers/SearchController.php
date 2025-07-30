<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessSearchJob;
use App\Models\SearchQuery;
use App\Models\SearchResult;

class SearchController extends Controller
{
    /**
     * Show the search form.
     */
    public function form()
    {
        return view('search.form');
    }

    /**
     * Handle the search form submission.
     */
    public function handle(Request $request)
    {
        // Validate the search query
        $validated = $request->validate([
            'query' => 'required|string|max:255',
        ]);

        // Store the search query with the authenticated user
        $searchQuery = SearchQuery::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'query' => $validated['query'],
        ]);

        // Dispatch a job to process the search asynchronously
        dispatch(new ProcessSearchJob($searchQuery));

        // Redirect to results page with immediate search
        return redirect()->route('search.results', ['query' => $validated['query']]);
    }

    /**
     * Show search results.
     */
    public function results(Request $request)
    {
        $query = $request->get('query');
        
        if (!$query) {
            return redirect()->route('search.form');
        }

        // Get immediate results from parts table
        $results = \App\Models\Part::where('name', 'LIKE', '%' . $query . '%')
            ->get()
            ->map(function ($part) {
                return (object) [
                    'part' => $part
                ];
            });

        return view('search.results', [
            'query' => $query,
            'results' => $results
        ]);
    }
}