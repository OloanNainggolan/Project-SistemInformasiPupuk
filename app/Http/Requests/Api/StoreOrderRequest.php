<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // auth handled by middleware
    }

    public function rules()
    {
        return [
            'user_id' => ['required','integer','exists:users,id'],
            'village_office' => ['nullable','string'],
            'items' => ['required','array','min:1'],
            'items.*.name' => ['required','string'],
            'items.*.quantity' => ['required','integer','min:1'],
            'items.*.price' => ['nullable','numeric','min:0'],
            'total_amount' => ['required','numeric','min:0'],
            'status' => ['nullable','in:Pending,Processing,Ready,Completed,Rejected'],
            'confirmed_by_user' => ['nullable','boolean'],
            'rejection_reason' => ['nullable','string'],
        ];
    }
}
