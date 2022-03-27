<?php

namespace Tests\Feature;

use App\Models\User as Agent;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CreateAgentTest extends TestCase
{
    public function test422()
    {
        $this->postJson(route('agent.create'))
            ->assertJsonStructure([
                'message',
                'errors' => ['first_name', 'last_name', 'email'],
            ])->assertUnprocessable();
    }

    public function testSuccess()
    {
        $agent    = Agent::factory()->agent()->make();
        $response = $this->postJson(route('agent.create'), $agent->toArray());

        $response->assertJsonStructure(['data' => [
            'firstName', 'lastName', 'email', 'token',
        ]])->assertCreated();

        $this->assertDatabaseHas('users', [
            'first_name' => $agent->first_name,
            'last_name'  => $agent->last_name,
            'email'      => $agent->email,
            'role'       => Agent::ROLE_AGENT,
        ]);
    }
}
