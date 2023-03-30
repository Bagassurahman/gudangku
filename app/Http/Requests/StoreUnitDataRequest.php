<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreUnitDataRequest extends FormRequest
{

    public function authorize()
    {
        abort_if(Gate::denies('unit_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'warehouse_unit' => [
                'required',
            ],
            'outlet_unit' => [
                'required',
            ],
        ];
    }
}
