<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreShowTest extends TestCase
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
    public function should_return_status_code_200_and_store_by_id()
    {

        $name = $this->faker->name;
       $store_id = factory(Store::class)->create(['name' => $name])->id;

        $response = $this->get($this::BASE_URL.$this::STORES."/$store_id");

        $response->assertStatus(200);
        $response->assertJson(['name' => $name]);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_the_id_not_found()
    {

        $response = $this->get($this::BASE_URL.$this::STORES.'/1');

        $response->assertStatus(404);
    }
}
