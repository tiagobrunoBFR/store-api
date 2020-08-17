<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_products_paginate()
    {
        factory(Product::class, 30)->create();

        $response = $this->get($this::BASE_URL.$this::PRODUCTS);

        $response->assertStatus(200);
        $responseArray = json_decode($response->getContent());
        $this->assertEquals(30, $responseArray->total);
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_array_empty_when_not_exist_products_in_database()
    {
        $response = $this->get($this::BASE_URL.$this::PRODUCTS);

        $response->assertStatus(200);
        $responseArray = json_decode($response->getContent());
        $this->assertEquals(0, $responseArray->total);
    }
}
