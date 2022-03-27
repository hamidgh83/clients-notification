<?php

namespace Tests\Feature;

use App\Http\Resources\ClientResource;
use App\Models\User as Client;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UpdateClientTest extends TestCase
{
    public function test404()
    {
        $this->patchJson(route('client.update', ['client' => time()]))->assertNotFound();
    }

    public function test422()
    {
        $client = Client::factory()->client()->create([
            'phone_number' => '+3741234567',
        ]);

        $response = $this
            ->patchJson(route('client.update', ['client' => $client->getKey()]), [
                'phone_number' => '1548',
            ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors' => ['phone_number']])
        ;
    }

    public function testSuccess()
    {
        $client = Client::factory()->client()->create([
            'phone_number' => $this->faker->e164PhoneNumber,
        ]);

        $response = $this->patchJson(
            route('client.update', ['client' => $client->getKey()]),
            ['phone_number' => $newPhoneNumber = $this->faker->e164PhoneNumber]
        );

        $client->phone_number = $newPhoneNumber;
        $response->assertSuccessful()->assertJson(
            ClientResource::make($client)
                ->response()
                ->getData(true),
        );

        $this->assertDatabaseHas('users', [
            'id'           => $client->getKey(),
            'phone_number' => $newPhoneNumber,
        ]);
    }
}
