@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <!--================================-->
        <!-- Breadcrumb Start -->
        <!--================================-->
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20">Dashboard</h1>
            </div>
            <div class="breadcrumb pd-0 mg-0">
                <a class="breadcrumb-item" href="index.html"><i class="icon ion-ios-home-outline"></i>
                    Home</a>
                <a class="breadcrumb-item" href="">Dashboard</a>

            </div>
        </div>
        <!--/ Breadcrumb End -->

    </div>
@endsection
@section('scripts')
    @parent
@endsection
