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
        Part::create(['name' => 'Alternator', 'price' => 150.00]);
        Part::create(['name' => 'Battery', 'price' => 89.99]);
        Part::create(['name' => 'Brake Pad', 'price' => 45.50]);

        // Debug: Check if data was created
        $allParts = Part::all();
        $this->assertEquals(3, $allParts->count(), 'Should have 3 parts in database');

        // Act
        $response = $this->getJson('/api/search?query=Battery');
        
        // Debug: Check response
        $responseData = $response->json();
        $this->assertNotNull($responseData, 'Response should not be null');
        
        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Battery']);
    }

    public function test_search_returns_empty_if_no_match()
    {
        Part::create(['name' => 'Alternator', 'price' => 150.00]);

        $response = $this->getJson('/api/search?query=unknown');

        $response->assertStatus(200);
        $response->assertExactJson([]);
    }
}
