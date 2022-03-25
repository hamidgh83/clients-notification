<?php

namespace App\Services;

use App\Models\User as Agent;
use App\Repositories\UserRepository as AgentRepository;

class AgentService
{
    protected AgentRepository $agentRepository;

    public function __construct(AgentRepository $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }

    public function create(array $data): Agent
    {
        $data['role'] = Agent::ROLE_AGENT;
        $agent        = $this->agentRepository->create($data);
        $token        = $agent->createToken('Agent token')->plainTextToken;

        return $agent->withAccessToken($token);
    }
}
