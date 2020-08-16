<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreUpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $name;
    private $email;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->email = $this->faker->email;
        $this->name = $this->faker->name;
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_store_updated_when_params_is_valid()
    {

       $store_id = factory(Store::class)->create()->id;

        $data = [
            'name' => $this->name,
            'email' => $this->email
        ];

        $response = $this->put($this::BASE_URL.$this::STORES."/$store_id", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('stores', [
            'name' => $this->name,
            'email' => $this->email
        ]);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_the_id_not_found()
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email
        ];

        $response = $this->put($this::BASE_URL.$this::STORES.'/1', $data);

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function should_return_status_code_422_when_email_exists_in_database()
    {

        $email = $this->faker->email;

        $store_id = factory(Store::class)->create(['email' => $email]);

        $data = [
            'name' => $this->faker->name,
            'email' => $email
        ];

        $response = $this->put($this::BASE_URL.$this::STORES."/$store_id", $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * @test
     * @dataProvider providerErrorBlank
     */
    public function should_return_status_code_422($data, $inputErro)
    {
        $store_id = factory(Store::class)->create()->id;

        $response = $this->put($this::BASE_URL . $this::STORES."/$store_id", $data);

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
                ],
                'inputErro' => 'name'
            ],
            'when name  not is string' => [
                'data' => [
                    'name' => 123,
                ],
                'inputErro' => 'name'
            ],
            'when the name has more than 40 characters' => [
                'data' => [
                    'name' => 'dddddddddddddddddddddddddddddddddddddddddd',
                ],
                'inputErro' => 'name'
            ],
            'when the name has less than 3 characters' => [
                'data' => [
                    'name' => 'dd',
                ],
                'inputErro' => 'name'
            ],
            'when email is blank' => [
                'data' => [
                    'email' => ''
                ],
                'inputErro' => 'email'
            ],
            'when email not is an email valid' => [
                'data' => [
                    'email' => 'email.com'
                ],
                'inputErro' => 'email'
            ],
            'when email not is string' => [
                'data' => [
                    'email' => 1232
                ],
                'inputErro' => 'email'
            ],
        ];
    }
}
