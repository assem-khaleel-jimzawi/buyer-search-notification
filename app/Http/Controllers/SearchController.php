<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessSearchJob;
use App\Models\SearchQuery;

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
            'user_id' =>Auth::check() ? Auth::id() : null,
            'query' => $validated['query'],
        ]);

        // Dispatch a job to process the search asynchronously
        dispatch(new ProcessSearchJob($searchQuery));

        // Return the user back with a status message
        return back()->with('status', 'Your search is being processed.');
    }
}