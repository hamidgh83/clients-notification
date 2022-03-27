<?php

namespace Tests\Feature;

use App\Models\User as Client;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class DeleteClientTest extends TestCase
{
    public function test404()
    {
        $this->getJson(route('client.delete', ['client' => time()]))->assertNotFound();
    }

    public function testSuccess()
    {
        $client = Client::factory()->client()->create();

        $response = $this->deleteJson(route('client.delete', ['client' => $client->getKey()]));

        $response->assertNoContent()->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'id' => $client->getKey(),
        ]);
    }
}
