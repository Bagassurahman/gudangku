<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreWarehouseManagementRequest extends FormRequest
{

    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'warehouse_name' => [
                'string',
                'required',
            ],
            'name'     => [
                'string',
                'required',
            ],
            'phone'    => [
                'required',
            ],
            'email'    => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'address' => [
                'required',
            ]
        ];
    }

    public function messages()
    {
        return [
            'warehouse_name.required' => 'Nama gudang harus diisi',
            'name.required'           => 'Nama harus diisi',
            'phone.required'          => 'Nomor telepon harus diisi',
            'email.required'          => 'Email harus diisi',
            'email.unique'            => 'Email sudah terdaftar',
            'password.required'       => 'Password harus diisi',
            'address.required'        => 'Alamat harus diisi',
        ];
    }
}
