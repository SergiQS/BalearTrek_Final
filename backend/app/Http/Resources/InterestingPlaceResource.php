<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TrekResource;
use App\Http\Resources\PlaceTypeResource;
class InterestingPlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //  return parent::toArray($request);

        return [
            'identifier' => $this->id,
            'name' => $this->name,
            'gps' => $this->gps,
            'treks' => TrekResource::collection($this->whenLoaded('treks')),
            'placeType' => new PlaceTypeResource($this->whenLoaded('placeType')),
        ];
    }
}
