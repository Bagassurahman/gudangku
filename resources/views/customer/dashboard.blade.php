<div class="pageheader pd-t-25 pd-b-35">
    <div class="pd-t-5 pd-b-5">
        <h1 class="pd-0 mg-0 tx-20">
            Selamat Datang, {{ Auth::user()->name }}
        </h1>
    </div>
</div>

<div class="row row-xs clearfix">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card card-dashboard">
                    <div class="card-body">
                        <h4 class="text-dark">Total Transaksi</h4>
                        <h2 class="text-dark">Rp. {{ number_format(Auth::user()->totalTransaction(), 0, ',', '.') }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card card-dashboard">
                    <div class="card-body">
                        <h4 class="text-dark">Total Point</h4>
                        <h2 class="text-dark">{{ Auth::user()->point }}</h2>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="col-12 mt-4">
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
