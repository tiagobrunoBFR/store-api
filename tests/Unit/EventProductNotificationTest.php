<?php

namespace Tests\Unit;

use App\Events\EventNotificationProductCreate;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class EventProductNotificationTest extends TestCase
{
    /**
     * @test
     */
    public function should_send_a_email_when_product_is_created()
    {
        Event::fake([
            EventNotificationProductCreate::class,
        ]);

        factory(Product::class)->create();

        Event::assertDispatched(EventNotificationProductCreate::class);
    }

    /**
     * @test
     */
    public function should_send_a_email_when_product_is_updated()
    {
        Event::fake([
            EventNotificationProductCreate::class,
        ]);

        $product = factory(Product::class)->create();

        $product->update(['name' => 'name_updated']);

        Event::assertDispatched(EventNotificationProductCreate::class, 2);
    }
}
