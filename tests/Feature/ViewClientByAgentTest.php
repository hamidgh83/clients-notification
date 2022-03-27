<?php

namespace Tests\Feature;

use App\Http\Resources\ClientResource;
use App\Models\User as Agent;
use App\Models\User as Client;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ViewClientByAgentTest extends TestCase
{
    public function test401()
    {
        $client = Client::factory()->client()->create();

        $this->getJson(route('agent.client.view', ['client' => $client->getKey()]))->assertUnauthorized();
    }

    public function test404()
    {
        $this
            ->actingAs(Agent::factory()->agent()->create())
            ->getJson(route('agent.client.view', ['client' => time()]))
            ->assertNotFound()
        ;
    }

    public function testSuccess()
    {
        $client = Client::factory()->client()->create();

        $this
            ->actingAs(Agent::factory()->agent()->create())
            ->getJson(route('agent.client.view', ['client' => $client->getKey()]))
            ->assertJson(ClientResource::make($client)->response()->getData(true))
            ->assertSuccessful()
        ;
    }
}
