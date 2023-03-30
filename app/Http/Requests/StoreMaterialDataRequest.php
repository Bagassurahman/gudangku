<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreMaterialDataRequest extends FormRequest
{

    public function authorize()
    {
        abort_if(Gate::denies('material_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }


    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'unit_id' => [
                'required',
                'integer',
            ],
            'selling_price' => [
                'required',
                'integer',
            ],
            'category' => [
                'required',
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama material harus diisi',
            'unit_id.required' => 'Satuan harus diisi',
            'selling_price.required' => 'Harga jual harus diisi',
            'category.required' => 'Kategori harus diisi',
        ];
    }
}
