@extends('layouts.admin')
@section('content')
    <div class="main-card">
        <div class="header">
            Tampilkan Data
        </div>

        <div class="body">

            <table class="striped bordered show-table">
                <tbody>
                    <tr>
                        <th>
                            Nomer
                        </th>
                        <td>
                            {{ $material->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Nama Bahan
                        </th>
                        <td>
                            {{ $material->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Satuan Gudang
                        </th>
                        <td>
                            {{ $material->unit->warehouse_unit ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Satuan Outlet
                        </th>
                        <td>
                            {{ $material->unit->outlet_unit ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="block pt-4">
                <a class="btn-md btn-gray" href="{{ route('admin.data-satuan.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
