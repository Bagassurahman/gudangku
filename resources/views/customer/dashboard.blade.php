<div class="pageheader pd-t-25 pd-b-35">
    <div class="pd-t-5 pd-b-5">
        <h1 class="pd-0 mg-0 tx-20">
            Selamat Datang, {{ Auth::user()->name }}
        </h1>
    </div>
</div>

<div class="row row-xs clearfix">
<<<<<<< HEAD
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h6 class="tx-12 text-uppercase tx-spacing-1 tx-color-02 tx-semibold text-dark">Point Kamu</h6>

                <h4 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">
                    {{ \App\Point::where('user_id', Auth::user()->id)->sum('point') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5">
=======
    <div class="col-12">
>>>>>>> 183e60f (update from cpanel)
        <h4 class="text-dark">Event Kami</h4>
        <div class="row mt-2">
            @foreach ($events as $event)
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card card-event">
                        <img src="{{ asset($event->image) }}" class="card-img-top">
                        <div class="card-body">
                            <h2 class="card-title">{{ $event->name }}</h2>
                            <p class="card-text">{{ $event->description }}</p>
                            <a href="{{ route('customer.event.show', $event->slug) }}"
                                class="btn btn-primary w-100">Lihat
                                Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
