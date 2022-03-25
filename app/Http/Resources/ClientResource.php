<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'firstName'   => $this->first_name,
            'lastName'    => $this->last_name,
            'email'       => $this->email,
            'phoneNumber' => $this->phone_number,
        ];
    }
}
