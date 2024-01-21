@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
    <div id="main-wrapper ">
        <div class="pageheader pd-t-25 ">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item active" aria-current="page">Tukar Poin</li>
                </ol>
            </nav>
        </div>
        <div class="row row-xs clearfix ">
            @foreach ($rewards as $reward)
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card card-event">
                        <img src="{{ asset($reward->image) }}" class="card-img-top">
                        <div class="card-body">
                            <h2 class="card-title">{{ $reward->name }}</h2>
                            <p class="card-text">{{ $reward->description }}</p>
                            <a href="{{ route('customer.reward.show', $reward->slug) }}" class="btn btn-primary w-100">Lihat
                                Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {!! $rewards->links() !!}
    </div>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
