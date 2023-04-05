@extends('layouts.admin')
@section('content')
    <div class="main-card">
        <div class="header">
            Beli
        </div>

        <div class="body">
            <div class="row ">
                @foreach ($materials as $material)
                    <div class="col-3">
                        <div class="material main-card">
                            <div class="header">
                                {{ $material->name }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
