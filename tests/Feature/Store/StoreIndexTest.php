<?php

namespace Tests\Feature\Store;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreIndexTest extends TestCase
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
    public function should_return_status_code_200_and_stores_paginate()
    {
        factory(Store::class, 30)->create();

        $response = $this->get($this::BASE_URL.$this::STORES);

        $response->assertStatus(200);
        $responseArray = json_decode($response->getContent());
        $this->assertEquals(30, $responseArray->total);
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_array_empty_when_not_exist_store_in_database()
    {
        $response = $this->get($this::BASE_URL.$this::STORES);

        $response->assertStatus(200);
        $responseArray = json_decode($response->getContent());
        $this->assertEquals(0, $responseArray->total);
    }

    /**
     * @test
     */
    public function should_search_store_by_name_and_return_status_code_200_and_store_searched()
    {
        factory(Store::class)->create(['name' => 'adidas']);

        $data = [
            'name' => 'adidas',
        ];

        $response = $this->json('GET', $this::BASE_URL . $this::STORES, $data);
        $response->assertStatus(200)
            ->assertJson(['data' => [['name' => 'adidas']]]);
    }

    /**
     * @test
     */
    public function should_search_store_by_email_and_return_status_code_200_and_store_searched()
    {
        factory(Store::class)->create(['email' => 'adidas@email.com']);

        $data = [
            'email' => 'adidas@email.com',
        ];

        $response = $this->json('GET', $this::BASE_URL . $this::STORES, $data);
        $response->assertStatus(200)
            ->assertJson(['data' => [['email' => 'adidas@email.com']]]);
    }
}
