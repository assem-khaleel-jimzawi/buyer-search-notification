<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_query_id',
        'part_id',
    ];

    /**
     * The search query this result belongs to.
     */
    public function searchQuery()
    {
        return $this->belongsTo(SearchQuery::class);
    }

    /**
     * The part associated with this search result.
     */
    public function part()
    {
        return $this->belongsTo(Part::class);
    }
}
