<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_relationship_one_to_many_a_product()
    {
        $store = factory('App\Models\Store')->create();

        factory('App\Models\Product', 4)->create(['store_id' => $store->id]);
        $this->assertInstanceOf(Collection::class, $store->products);
    }
}
