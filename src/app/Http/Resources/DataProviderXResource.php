<?php

namespace App\Http\Resources;

use App\Models\DataProviderX;
use Illuminate\Http\Resources\Json\JsonResource;

class DataProviderXResource extends JsonResource
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
            'id' => $this->parentIdentification,
            'email' => $this->parentEmail,
            'balance' => $this->parentAmount,
            'currency' => $this->Currency,
            'status' => DataProviderX::STATES_CODES_REVERSED[$this->statusCode],
            'created_at' => $this->registerationDate,
        ];
    }
}
