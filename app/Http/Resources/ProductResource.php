<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sku' => $this->sku,
            'pcode' => $this->pcode,
            'pcodes' => $this->pcodes,
            'jianjie1' => $this->jianjie1,
            'jianjie2' => $this->jianjie2,
            'category' => $this->category,
            'brand' => $this->brand,
            'cover_img' => $this->cover_img,
            'imgs' => $this->imgs,
            'dl' => $this->dl,
            'dy' => $this->dy,
            'type' => $this->type,
            'size' => $this->size,
            'bzq' => $this->bzq,
            'price_eu' => $this->price_eu,
            'price_us' => $this->price_us,
            'price_uk' => $this->price_uk,
            'price_jp' => $this->price_jp,
            'status' => $this->status,
            'replace' => $this->replace,
            'description' => $this->description,
            'stock' => $this->stocks($this->warehouse),
            'warehouse' => $this->warehouse,
            'data' => $this->created_at
        ];
    }

    public function stocks($results): int
    {
        $stocks = 0;
        foreach ($results as $result) {
            $stocks += $result->pivot->stock;
        }
        return $stocks;
    }
}
