@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Izin</h1>
            </div>

        </div>
        <div class="row row-xs clearfix">

            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Data Izin
                        </h4>
                        <div class="card-header-btn">
                            <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse1"
                                aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                            <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                                    class="ion-android-refresh"></i></a>
                            <a href="#" data-toggle="expand" class="btn card-expand"><i
                                    class="ion-android-expand"></i></a>
                            <a href="#" data-toggle="remove" class="btn card-remove"><i
                                    class="ion-android-close"></i></a>
                        </div>
                    </div>
                    <div class="card-body collapse show" id="collapse1">
                        <form method="POST" action="{{ route('admin.roles.update', [$role->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">{{ trans('cruds.role.fields.title') }}<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('title')
                                            is-invalid
                                        @enderror"
                                    type="text" name="title" value="{{ old('title', $role->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="text-xs required"
                                    for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn-sm btn-indigo select-all"
                                        style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                    <span class="btn-sm btn-indigo deselect-all"
                                        style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                </div>
                            </div>
                            <div class="body">

                                <div class="mb-3">
                                    <label class="text-xs required"
                                        for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                                    <div style="padding-bottom: 4px">
                                        <span class="btn-sm btn-indigo select-all"
                                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn-sm btn-indigo deselect-all"
                                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <select class="select2{{ $errors->has('users') ? ' is-invalid' : '' }}"
                                        name="permissions[]" id="permissions" multiple required>
                                        @foreach ($permissions as $id => $permissions)
                                            <option value="{{ $id }}"
                                                {{ in_array($id, old('permissions', [])) || $role->permissions->contains($id) ? 'selected' : '' }}>
                                                {{ $permissions }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('permissions'))
                                        <p class="invalid-feedback">{{ $errors->first('permissions') }}</p>
                                    @endif
                                    <span class="block">{{ trans('cruds.role.fields.permissions_helper') }}</span>
                                </div>
                            </div>

                            <div class="footer">
                                <button type="submit" class="submit-button">{{ trans('global.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection
