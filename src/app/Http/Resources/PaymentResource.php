<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'creds' => $this->creds,
            'sum' => number_format(((int)$this->sum * 0.01), 2),
            'currency' => new CurrencyResource($this->currency),
            'user' => new UserResource($this->user),
            'status' => $this->status,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
