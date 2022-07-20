<?php

namespace App\Http\Resources;

use App\Models\Purchase;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'title' => $this->title,
            'remark' => $this->Remark,
            'items' => PurchaseItemResource::collection($this->items),
            'status' => $this->status,
            'status_text' => Purchase::PURCHASE_STATUS_GROUP[$this->status],
            'user'=>UserResource::make($this->user),
            'deadline_at' => $this->deadline_at,
            'complete_at' => $this->complete_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
