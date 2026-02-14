<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return [
            'identifier' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastName,
            'email' => $this->email,
            'dni' => $this->dni,
            'phone' => $this->phone,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),

        ];
    }
}
