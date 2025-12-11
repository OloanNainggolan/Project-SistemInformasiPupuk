<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'order_number' => $this->order_number,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id ?? null,
                    'name' => $this->user->name ?? null,
                    'email' => $this->user->email ?? null,
                    'no_telp' => $this->user->no_telp ?? null,
                    'address' => $this->user->address ?? null,
                ];
            }),
            'items' => $this->items,
            'total_amount' => (float) $this->total_amount,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'confirmed_by_user' => (bool) $this->confirmed_by_user,
            'rejection_reason' => $this->rejection_reason,
            'village_office' => $this->village_office,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
