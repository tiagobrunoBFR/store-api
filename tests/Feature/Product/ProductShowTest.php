<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductShowTest extends TestCase
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
    public function should_return_status_code_200_and_product_by_id()
    {
        $name = $this->faker->name;
        $product_id = factory(Product::class)->create(['name' => $name])->id;

        $response = $this->get($this::BASE_URL.$this::PRODUCTS."/$product_id");

        $response->assertStatus(200);
        $response->assertJson(['name' => $name]);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_the_id_not_found()
    {
        $response = $this->get($this::BASE_URL.$this::PRODUCTS.'/1');

        $response->assertStatus(404);
    }
}
