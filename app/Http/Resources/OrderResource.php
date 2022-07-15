<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'trans_id' => $this->trans_id,
            'order_number' => $this->order_number,
            'total' => $this->total,
            'currency' => $this->currency,
            'total_usd' => $this->total_usd,
            'description' => $this->description,
            'ip' => $this->ip,
            'url' => $this->url,
            'product_code' => $this->product_code,
            'is_shipping' => $this->is_shipping,
            'link_status' => $this->link_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'user_info' => [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'postal' => $this->postal,
                'country' => $this->country,
                'state' => $this->state,
                'city' => $this->city,
                'street1' => $this->street1,
                'street2' => $this->street2,
            ],
        ];
    }
}
