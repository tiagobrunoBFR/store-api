<?php

namespace Tests\Feature\Product;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCreateTest extends TestCase
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
    public function should_return_status_code_201_and_product_created_when_params_is_valid()
    {
        $store_id = factory(Store::class)->create()->id;

        $data = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 999999),
            'store_id' => $store_id,
            'active' => $this->faker->boolean
        ];

        $response = $this->post($this::BASE_URL . $this::PRODUCTS, $data);
        $response->assertStatus(201);
    }

    /**
     * @test
     * @dataProvider providerError
     */
    public function should_return_status_code_422($data, $inputErro)
    {
        $response = $this->post($this::BASE_URL . $this::PRODUCTS, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($inputErro);
    }

    public function providerError()
    {
        $this->refreshApplication();

        $store_id = factory(Store::class)->create()->id;

        return [
            'when name is blank' => [
                'data' => [
                    'name' => '',
                    'price' => 10,
                    'store_id' => $store_id,
                    'active' => true,
                ],
                'inputErro' => 'name'
            ],
            'when name not is string' => [
                'data' => [
                    'name' => 123,
                    'price' => 10,
                    'store_id' => $store_id,
                    'active' => true,
                ],
                'inputErro' => 'name'
            ],
            'when the name has more than 60 characters' => [
                'data' => [
                    'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
                    'price' => 10,
                    'store_id' => $store_id,
                    'active' => true,
                ],
                'inputErro' => 'name'
            ],
            'when the name has less than 3 characters' => [
                'data' => [
                    'name' => 'aa',
                    'price' => 10,
                    'store_id' => $store_id,
                    'active' => true,
                ],
                'inputErro' => 'name'
            ],
            'when the price has less than 2 characters' => [
                'data' => [
                    'name' => 'teste',
                    'price' => 1,
                    'store_id' => $store_id,
                    'active' => true,
                ],
                'inputErro' => 'price'
            ],
            'when the price has more than 6 digits' => [
                'data' => [
                    'name' => 'teste',
                    'price' => 1123333,
                    'store_id' => $store_id,
                    'active' => true,
                ],
                'inputErro' => 'price'
            ],
            'when the price is blank' => [
                'data' => [
                    'name' => 'teste',
                    'price' => '',
                    'store_id' => $store_id,
                    'active' => true,
                ],
                'inputErro' => 'price'
            ],
            'when store_id not exists in database' => [
                'data' => [
                    'name' => 'teste',
                    'price' => 111,
                    'store_id' => 20,
                    'active' => true,
                ],
                'inputErro' => 'store_id'
            ],
            'when store_id is blank' => [
                'data' => [
                    'name' => 'teste',
                    'price' => 111,
                    'store_id' => '',
                    'active' => true,
                ],
                'inputErro' => 'store_id'
            ],
            'when active not is boolean' => [
                'data' => [
                    'name' => 'teste',
                    'price' => 111,
                    'store_id' => '',
                    'active' => 'true',
                ],
                'inputErro' => 'active'
            ],
        ];
    }
}
