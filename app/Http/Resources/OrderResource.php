<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->only('id', 'first_name', 'last_name', 'email') +
            [
                'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
                'order_total' => $this->total
            ];
    }
}
