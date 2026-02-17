<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityResource extends JsonResource
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
            'zone' => new ZoneResource($this->whenLoaded('zone')),
            'island' => new IslandResource($this->whenLoaded('island')),


        ];
    }
}
