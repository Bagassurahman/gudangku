<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRewardRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => 'required',
            'point'            => 'required|numeric',
            'description'      => 'required',
            'image'            => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock'            => 'required|numeric',
        ];
    }
}
