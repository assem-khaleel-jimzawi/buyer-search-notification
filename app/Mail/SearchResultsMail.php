<?php

namespace App\Mail;

use App\Models\SearchQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SearchResultsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $searchQuery;
    public $matches;

    /**
     * Create a new message instance.
     */
    public function __construct(SearchQuery $searchQuery, $matches)
    {
        $this->searchQuery = $searchQuery;
        $this->matches = $matches;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Search Results for Your Query')
            ->view('emails.search_results')
            ->with([
                'query' => $this->searchQuery->query,
                'matches' => $this->matches,
            ]);
    }
}
