<?php

namespace App\Jobs;

use App\Models\Part;
use App\Models\SearchQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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

        // Use FULLTEXT search instead of LIKE for better performance
        $matches = Part::whereFullText('name', $query)->get();

        foreach ($matches as $match) {
            SearchResult::create([
                'search_query_id' => $this->searchQuery->id,
                'part_id' => $match->id,
            ]);
        }

        // Send results via email
        Mail::to($this->searchQuery->user->email)
            ->send(new SearchResultsMail($this->searchQuery, $matches));

    }
}
