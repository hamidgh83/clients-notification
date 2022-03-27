<?php

namespace Tests\Feature;

use App\Models\User as Client;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CreateClientTest extends TestCase
{
    public function test422()
    {
        $this->postJson(route('client.create'))
            ->assertJsonStructure([
                'message',
                'errors' => ['first_name', 'last_name', 'email', 'phone_number'],
            ])->assertUnprocessable();
    }

    public function testSuccess()
    {
        $client = Client::factory()->client()->make();

        $response = $this->postJson(route('client.create'), $client->toArray());

        $response->assertJsonStructure(['data' => [
            'firstName', 'lastName', 'email',
        ]])->assertCreated();

        $this->assertDatabaseHas('users', [
            'first_name' => $client->first_name,
            'last_name'  => $client->last_name,
            'email'      => $client->email,
            'role'       => Client::ROLE_CLIENT,
        ]);
    }
}
