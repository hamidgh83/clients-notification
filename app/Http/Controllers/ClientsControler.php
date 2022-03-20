<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
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
     *
     * @param CLient $client
     * @return ClientResource
     */
    public function get(CLient $client): ClientResource
    {
        return ClientResource::make($client);
    }
    
    /**
     * Create a new client.
     *
     * @param CreateClientRequest $request
     * @return JsonResponse
     */
    public function create(CreateClientRequest $request): JsonResponse
    {
        $client = $this->clientService->create($request->validated());
        
        return ClientResource::make($client)
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update an identified client. 
     *
     * @param Client $client
     * @param UpdateClientRequest $request
     * @return ClientResource
     */
    public function update(Client $client, UpdateClientRequest $request): ClientResource
    {
        $client = $this->clientService->update($client, $request->validated());
        
        return ClientResource::make($client);
    }

    /**
     * Delete an identified client.
     *
     * @param CLient $client
     * @return JsonResponse
     */
    public function delete(CLient $client): JsonResponse
    {
        if ($this->clientService->delete($client)) {
            return response()->json(['message' => 'The client deleted successfully.']);
        }

        return response()
                ->setStatusCode(Response::HTTP_LOCKED)
                ->json(['message' => 'Cannot delete client.']);
    }
}
