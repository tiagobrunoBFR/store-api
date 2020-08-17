<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $data;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->data = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 2, 6),
            'active' => $this->faker->boolean
        ];
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_product_updated_when_params_is_valid()
    {
        $product_id = factory(Product::class)->create()->id;

        $response = $this->put($this::BASE_URL . $this::PRODUCTS."/$product_id", $this->data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', $this->data);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_the_id_is_not_found()
    {

        $response = $this->put($this::BASE_URL . $this::PRODUCTS.'/1', $this->data);
        $response->assertStatus(404);
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

        return [
            'when name is blank' => [
                'data' => [
                    'name' => '',
                ],
                'inputErro' => 'name'
            ],
            'when name not is string' => [
                'data' => [
                    'name' => 123,
                ],
                'inputErro' => 'name'
            ],
            'when the name has more than 60 characters' => [
                'data' => [
                    'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
                ],
                'inputErro' => 'name'
            ],
            'when the name has less than 3 characters' => [
                'data' => [
                    'name' => 'aa',
                ],
                'inputErro' => 'name'
            ],
            'when the price has less than 2 characters' => [
                'data' => [
                    'price' => 1,
                ],
                'inputErro' => 'price'
            ],
            'when the price has more than 6 character' => [
                'data' => [
                    'price' => 1123333,
                ],
                'inputErro' => 'price'
            ],
            'when the price is blank' => [
                'data' => [
                    'price' => '',
                ],
                'inputErro' => 'price'
            ],
            'when store_id not exists in database' => [
                'data' => [
                    'store_id' => 20,
                ],
                'inputErro' => 'store_id'
            ],
            'when store_id is blank' => [
                'data' => [
                    'store_id' => '',
                ],
                'inputErro' => 'store_id'
            ],
            'when active not is boolean' => [
                'data' => [
                    'active' => 'true',
                ],
                'inputErro' => 'active'
            ],
        ];
    }
}
