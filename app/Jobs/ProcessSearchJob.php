<?php

namespace App\Jobs;

use App\Models\Part;
use App\Models\SearchQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\SearchResult;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SearchResultsMail;


class ProcessSearchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $searchQuery;

    /**
     * Create a new job instance.
     */
    public function __construct(SearchQuery $searchQuery)
    {
        $this->searchQuery = $searchQuery;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $query = $this->searchQuery->query;

        // Use LIKE search for consistency with the API
        $matches = Part::where('name', 'LIKE', '%' . $query . '%')->get();

        // Create search results for each match
        foreach ($matches as $match) {
            SearchResult::create([
                'search_query_id' => $this->searchQuery->id,
                'part_id' => $match->id,
            ]);
        }

        // Only send email if user exists and has email
        if ($this->searchQuery->user && $this->searchQuery->user->email) {
            Mail::to($this->searchQuery->user->email)
                ->send(new SearchResultsMail($this->searchQuery, $matches));
        }

        // Log the search results for debugging
        Log::info("Search completed for query: {$query}", [
            'query_id' => $this->searchQuery->id,
            'matches_found' => $matches->count(),
            'user_id' => $this->searchQuery->user_id,
        ]);
    }
}
