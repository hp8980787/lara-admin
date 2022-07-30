<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
//            'storehouse_id' => $this->storehouse_id,
            'storehouse' => StorehouseResource::make($this->storehouse),
//            'product_id' => $this->product_id,
            'product' => ProductResource::make($this->product),

            'quantity' => $this->quantity,
            'reviewer' =>UserResource::make($this->user),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
