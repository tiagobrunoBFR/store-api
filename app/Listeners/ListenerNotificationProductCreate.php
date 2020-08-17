<?php

namespace App\Listeners;

use App\Events\EventNotificationProductCreate;
use App\Mail\ProductMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenerNotificationProductCreate implements ShouldQueue
{
    use Queueable;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventNotificationProductCreate  $event
     * @return void
     */
    public function handle(EventNotificationProductCreate $event)
    {
        $product = $event->getProduct();
        Mail::to($product->store->email)->queue(new ProductMail($product));
    }
}
