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

            'description' => $this->description,

            'price' => (float) $this->price,

            'image'=>$this->image ? asset('storage/'.$this->image) : null,

            'created_at' => $this->created_at->format('d-m-Y H:i:s'),

        ];
    }
}
