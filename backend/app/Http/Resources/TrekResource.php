<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);

        return [
            'identifier' => $this->id,
            'regNumber' => $this->regNumber,
            'name' => $this->name,
            'status' => $this->status,
            'municipality_id' => $this->municipality_id,
            'totalRating' => $this->totalRating,
            'countRating' => $this->countRating,
            'rating' => $this->rating,
            'municipality' => new MunicipalityResource(
                $this->whenLoaded('municipality')
            ),
            'interestingPlaces' => InterestingPlaceResource::collection(
                $this->whenLoaded('interestingPlaces')
            ),
            'meetings' => MeetingResource::collection(
                $this->whenLoaded('meetings')
            ),

            // $this->merge(
            //     [
            //         'intersesting_places' => InterestingPlaceResource::collection($this->whenLoaded('interesting_places')),
            //         'meetings' => MeetingResource::collection($this->whenLoaded('meetings')),
            //     ],
            // )
        ];
    }
}
