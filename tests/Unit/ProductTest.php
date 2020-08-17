<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_relationship_one_to_one_a_store()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf('App\Models\Store', $product->store);
    }
}
