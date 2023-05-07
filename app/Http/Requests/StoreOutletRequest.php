<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreOutletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'name' => [
                'required',
            ],
            'outlet_name' => [
                'required',
            ],
            'target' => [
                'required'
            ],
            'warehouse_id' => [
                'required'
            ],
            'phone_number' => [
                'required'
            ],
            'address' => [
                'required'
            ],
            'email' => [
                'required',
                'unique:users'
            ],
            'password' => [
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'outlet_name.required' => 'Nama outlet tidak boleh kosong',
            'target.required' => 'Target tidak boleh kosong',
            'warehouse_id.required' => 'Gudang tidak boleh kosong',
            'phone_number.required' => 'Nomor telepon tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong'
        ];
    }
}
