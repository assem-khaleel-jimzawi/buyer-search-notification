<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'query',
    ];

    /**
     * The user who made this search query.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Search results related to this query.
     */
    public function results()
    {
        return $this->hasMany(SearchResult::class);
    }
}
