<?php

namespace Tests\Feature;

use App\Http\Resources\ClientResource;
use App\Models\User as Client;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class GetClientTest extends TestCase
{
    public function test404()
    {
        $this->getJson('client.view')->assertNotFound();
    }

    public function testSuccess()
    {
        $client = Client::factory()->client()->create();

        $response = $this->getJson(route('client.view', ['client' => $client->getKey()]));

        $response->assertSuccessful()->assertJson(
            ClientResource::make($client)
                ->response()
                ->getData(true)
        );
    }
}
