<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductDestroyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function should_return_status_code_204_when_product_is_deleted()
    {
        $product_id = factory(Product::class)->create()->id;

        $response = $this->delete($this::BASE_URL.$this::PRODUCTS."/$product_id");

        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_the_id_not_found()
    {
        $response = $this->delete($this::BASE_URL.$this::PRODUCTS.'/1');

        $response->assertStatus(404);
    }
}
