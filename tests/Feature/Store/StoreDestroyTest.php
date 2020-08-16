<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreDestroyTest extends TestCase
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
    public function should_return_status_code_204_when_store_is_deleted()
    {
        $store_id = factory(Store::class)->create()->id;

        $response = $this->delete($this::BASE_URL.$this::STORES."/$store_id");

        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_the_id_not_found()
    {

        $response = $this->delete($this::BASE_URL.$this::STORES.'/1');

        $response->assertStatus(404);
    }
}
