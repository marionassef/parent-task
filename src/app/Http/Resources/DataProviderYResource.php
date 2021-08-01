<?php

namespace App\Http\Resources;

use App\Models\DataProviderX;
use App\Models\DataProviderY;
use Illuminate\Http\Resources\Json\JsonResource;

class DataProviderYResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'balance' => $this->balance,
            'currency' => $this->currency,
            'status' => DataProviderY::STATES_CODES_REVERSED[$this->status],
            'created_at' => $this->created_at,
        ];
    }
}
