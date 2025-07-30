<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Part;
use App\Models\SearchQuery;
use App\Models\SearchResult;
use App\Jobs\ProcessSearchJob;
use Illuminate\Support\Facades\Queue;

class CompleteSearchFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_search_flow_creates_search_results()
    {
        // Arrange: Create some parts
        Part::create(['name' => 'Battery', 'price' => 89.99]);
        Part::create(['name' => 'Alternator', 'price' => 150.00]);
        Part::create(['name' => 'Brake Pad', 'price' => 45.50]);

        // Create search query directly (simulating form submission)
        $searchQuery = SearchQuery::create([
            'query' => 'Battery',
            'user_id' => null
        ]);

        // Act: Process the search job
        $job = new ProcessSearchJob($searchQuery);
        $job->handle();

        // Assert: Search results were created
        $this->assertDatabaseHas('search_results', [
            'search_query_id' => $searchQuery->id,
            'part_id' => Part::where('name', 'Battery')->first()->id
        ]);

        // Check that we have exactly one search result
        $this->assertEquals(1, SearchResult::where('search_query_id', $searchQuery->id)->count());
    }

    public function test_search_job_handles_no_matches()
    {
        // Arrange: Create a search query
        $searchQuery = SearchQuery::create([
            'query' => 'NonExistentPart',
            'user_id' => null
        ]);

        // Act: Process the search job
        $job = new ProcessSearchJob($searchQuery);
        $job->handle();

        // Assert: No search results should be created
        $this->assertEquals(0, SearchResult::where('search_query_id', $searchQuery->id)->count());
    }

    public function test_search_job_handles_multiple_matches()
    {
        // Arrange: Create parts with similar names
        Part::create(['name' => 'Battery', 'price' => 89.99]);
        Part::create(['name' => 'Battery Pack', 'price' => 120.00]);
        Part::create(['name' => 'Car Battery', 'price' => 95.00]);

        $searchQuery = SearchQuery::create([
            'query' => 'Battery',
            'user_id' => null
        ]);

        // Act: Process the search job
        $job = new ProcessSearchJob($searchQuery);
        $job->handle();

        // Assert: All matching parts should have search results
        $this->assertEquals(3, SearchResult::where('search_query_id', $searchQuery->id)->count());
    }
} 