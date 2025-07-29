<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    // Fillable fields to allow mass assignment
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    /**
     * Example relationship: A part might have many search results (if you track search results).
     */
    public function searchResults()
    {
        return $this->hasMany(SearchResult::class);
    }

    /**
     * Scope for full-text search on 'name'.
     * Use like: Part::searchByName('query')->get();
     */
    public function scopeSearchByName($query, $term)
    {
        return $query->whereFullText('name', $term);
    }
}
