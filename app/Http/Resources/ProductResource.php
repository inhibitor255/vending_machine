<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_name' => $this->name,
            'price' => number_format($this->price, 2),
            'in_stock' => $this->quantityAvailable,
            'last_updated' => $this->updated_at->toDateTimeString(),
        ];
    }
}
