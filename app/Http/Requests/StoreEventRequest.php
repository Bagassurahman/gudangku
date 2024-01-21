<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' => 'required',
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Event tidak boleh kosong',
            'description.required' => 'Deskripsi Event tidak boleh kosong',
            'date.required' => 'Tanggal Event tidak boleh kosong',
            'time.required' => 'Waktu Event tidak boleh kosong',
            'location.required' => 'Lokasi Event tidak boleh kosong',
            'image.required' => 'Gambar Event tidak boleh kosong',
        ];
    }
}
