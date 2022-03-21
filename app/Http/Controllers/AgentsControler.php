<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgentRequest;
use App\Http\Resources\AgentResource;
use App\Services\AgentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AgentsControler extends Controller
{
    protected AgentService $agentService;
    
    public function __construct(AgentService $agentService)
    {
        $this->agentService  = $agentService;   
    }

    /**
     * Create an agent and return its resource.
     *
     * @param CreateAgentRequest $request
     * @return JsonResponse
     */
    public function create(CreateAgentRequest $request): JsonResponse
    {
        $agent = $this->agentService->create($request->validated());
        
        return AgentResource::make($agent)
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }
}
