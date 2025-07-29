<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Part;

class PartSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_matching_parts()
    {
        // Arrange
        Part::create(['name' => 'Alternator']);
        Part::create(['name' => 'Battery']);
        Part::create(['name' => 'Brake Pad']);

        // Act
        $response = $this->getJson('/search?query=batt');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Battery']);
    }

    public function test_search_returns_empty_if_no_match()
    {
        Part::create(['name' => 'Alternator']);

        $response = $this->getJson('/search?query=unknown');

        $response->assertStatus(200);
        $response->assertExactJson([]);
    }
}
