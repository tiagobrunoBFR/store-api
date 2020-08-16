<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreCreateTest extends TestCase
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
    public function should_return_status_code_201_and_store_create_when_params_is_Valid()
    {

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];

        $response = $this->post($this::BASE_URL . $this::STORES, $data);
        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function should_return_status_code_422_when_email_exists_in_database()
    {

        $email = $this->faker->email;

        factory(Store::class)->create(['email' => $email]);

        $data = [
            'name' => $this->faker->name,
            'email' => $email
        ];

        $response = $this->post($this::BASE_URL . $this::STORES, $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * @test
     * @dataProvider providerErrorBlank
     */
    public function should_return_status_code_422($data, $inputErro)
    {
        $response = $this->post($this::BASE_URL . $this::STORES, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($inputErro);
    }

    public function providerErrorBlank()
    {
        $this->refreshApplication();

        return [
            'when name is blank' => [
                'data' => [
                    'name' => '',
                    'email' => 'email@email.com'
                ],
                'inputErro' => 'name'
            ],
            'when name  not is string' => [
                'data' => [
                    'name' => 123,
                    'email' => 'email@email.com'
                ],
                'inputErro' => 'name'
            ],
            'when the name has more than 40 characters' => [
                'data' => [
                    'name' => 'dddddddddddddddddddddddddddddddddddddddddd',
                    'email' => 'email@email.com'
                ],
                'inputErro' => 'name'
            ],
            'when the name has less than 3 characters' => [
                'data' => [
                    'name' => 'dd',
                    'email' => 'email@email.com'
                ],
                'inputErro' => 'name'
            ],
            'when email is blank' => [
                'data' => [
                    'name' => 'test',
                    'email' => ''
                ],
                'inputErro' => 'email'
            ],
            'when email not is an email valid' => [
                'data' => [
                    'name' => 'test',
                    'email' => 'email.com'
                ],
                'inputErro' => 'email'
            ],
            'when email not is string' => [
                'data' => [
                    'name' => 'test',
                    'email' => 'email.com'
                ],
                'inputErro' => 'email'
            ],
        ];
    }
}
