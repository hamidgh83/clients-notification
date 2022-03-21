<?php

namespace App\Services;

use App\Http\Resources\ClientCollection;
use App\Models\User as Client;
use App\Repositories\UserRepository as ClientRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    protected ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function create(array $data): Client
    {
        return $this->clientRepository->create($data);
    }

    public function update(Client $client, array $data)
    {
        return $this->clientRepository->update($client, $data);
    }
    
    public function delete(Client $client): bool
    {
        return $this->clientRepository->delete($client) ? true : false;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->clientRepository->findAll([
            ['role', '=', Client::ROLE_CLIENT]
        ]);
    }
}