<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\User as CLient;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClientsControler extends Controller
{
    protected ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Get an identified client resource.
     */
    public function get(CLient $client): ClientResource
    {
        return ClientResource::make($client);
    }

    /**
     * Get a paginated list of clients.
     */
    public function getAll(): ClientCollection
    {
        return ClientCollection::make($this->clientService->getAll());
    }

    /**
     * Create a new client.
     */
    public function create(CreateClientRequest $request): JsonResponse
    {
        $client = $this->clientService->create($request->validated());

        return ClientResource::make($client)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
        ;
    }

    /**
     * Update an identified client.
     */
    public function update(Client $client, UpdateClientRequest $request): JsonResponse
    {
        $client = $this->clientService->update($client, $request->validated());

        return ClientResource::make($client)
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED)
        ;
    }

    /**
     * Delete an identified client.
     */
    public function delete(CLient $client): Response
    {
        $this->clientService->delete($client);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
