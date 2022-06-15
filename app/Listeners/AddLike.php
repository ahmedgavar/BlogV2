<?php

namespace App\Listeners;

use App\Events\PostLike;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddLike
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(PostLike $event)
    {
        //
        

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
