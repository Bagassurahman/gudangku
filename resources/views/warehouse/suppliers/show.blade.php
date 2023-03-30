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
                            {{ $supplier->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Nama Supllier
                        </th>
                        <td>
                            {{ $supplier->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Alamat Supplier
                        </th>
                        <td>
                            {{ $supplier->address ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Nomer Hp
                        </th>
                        <td>
                            {{ $supplier->phone ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="block pt-4">
                <a class="btn-md btn-gray" href="{{ route('warehouse.suppliers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
