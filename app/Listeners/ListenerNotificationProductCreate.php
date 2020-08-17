<?php

namespace App\Listeners;

use App\Events\EventNotificationProductCreate;
use App\Mail\ProductMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenerNotificationProductCreate
{
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
        Mail::to($product->store->email)->send(new ProductMail($product));
    }
}
