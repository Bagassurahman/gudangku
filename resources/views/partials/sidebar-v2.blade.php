<div class="page-sidebar">
    <div class="logo">
        <a class="logo-img" href="{{ route('dashboard') }}">
            <img class="desktop-logo" src="{{ asset('images/zam-zam.png') }}" alt="">
            <img class="small-logo" src="{{ asset('images/logo-zamzam.jpeg') }}" alt="">
        </a>
        <i class="ion-ios-close-empty" id="sidebar-toggle-button-close"></i>
    </div>
    <!--================================-->
    <!-- Sidebar Menu Start -->
    <!--================================-->
    <div class="page-sidebar-inner">
        <div class="page-sidebar-menu">
            <ul class="accordion-menu">
                <li class="{{ request()->is('dashboard') ? ' active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i data-feather="layout"></i>
                        <span>Dashboard</span></a>
                </li>
                @can('dashboard_customer_access')
                    <li class="{{ request()->is('customer/event') ? ' active' : '' }}">
                        <a href="{{ route('customer.event.index') }}"><i data-feather="layout"></i>
                            <span>Event</span></a>
                    </li>
                    <li class="{{ request()->is('customer/transaksi-saya') ? ' active' : '' }}">
                        <a href="{{ route('customer.transaction.index') }}"><i data-feather="dollar-sign"></i>
                            <span>Transaksi Saya</span></a>
                    </li>
                    <li class="{{ request()->is('customer/tukar-poin') ? ' active' : '' }}">
                        <a href="{{ route('customer.reward.index') }}"><i data-feather="shopping-bag"></i>
                            <span>Tukar Poin</span></a>
                    </li>
                @endcan
                @can('transaction_access')
                    <li
                        class="{{ request()->is('gudang/persediaan*', 'gudang/distribusi*', 'outlet/request*', 'gudang/data-request-bahan*', 'outlet/jurnal-kas*', 'outlet/setoran*', 'gudang/setoran*', 'outlet/distribusi*', 'outlet/persediaan*', 'finance/setoran*', 'finance/hutang-piutang*', 'gudang/hutang-piutang*') ? ' active open' : '' }}">

                        <a href=""><i data-feather="clipboard"></i>
                            <span>Transaksi</span><i class="accordion-icon fa fa-angle-left"></i></a>
                        <ul class="sub-menu" style="display: block;">

                            @can('request_access')
                                <li class="{{ request()->is('outlet/request*') ? ' active' : '' }}"><a
                                        href="{{ route('outlet.request.index') }}">Request Bahan</a>
                                </li>
                            @endcan
                            @can('inventory_outlet_access')
                                <li class="{{ request()->is('outlet/persediaan*') ? ' active' : '' }}"><a
                                        href="{{ route('outlet.persediaan.index') }}">Persediaan</a>
                                </li>
                            @endcan
                            @can('inventory_access')
                                <li class="{{ request()->is('gudang/persediaan*') ? ' active' : '' }}"><a
                                        href="{{ route('warehouse.persediaan.index') }}">Persediaan</a>
                                </li>
                            @endcan
                            @can('distribution_access')
                                <li class="{{ request()->is('gudang/distribusi*') ? ' active' : '' }}"><a
                                        href="{{ route('warehouse.distribusi.index') }}">Distribusi</a>
                                </li>
                            @endcan
                            @can('distribution_outlet_access')
                                <li class="{{ request()->is('outlet/distribusi*') ? ' active' : '' }}"><a
                                        href="{{ route('outlet.distribusi.index') }}">Distribusi</a>
                                </li>
                            @endcan

                            @can('request_distribution_acces')
                                <li class="{{ request()->is('gudang/data-request-bahan*') ? ' active' : '' }}"><a
                                        href="{{ route('warehouse.data-request-bahan.index') }}">Data Request Bahan</a>
                                </li>
                            @endcan
                            @can('cash_journal_outlet_access')
                                <li class="{{ request()->is('outlet/jurnal-kas*') ? ' active' : '' }}"><a
                                        href="{{ route('outlet.jurnal-kas.index') }}">Jurnal Kas</a>
                                </li>
                            @endcan
                            @can('deposit_outlet_access')
                                <li class="{{ request()->is('outlet/setoran*') ? ' active' : '' }}"><a
                                        href="{{ route('outlet.setoran.index') }}">Setoran</a>
                                </li>
                            @endcan
                            {{-- @can('deposit_warehouse_access')
                                    <li class="{{ request()->is('gudang/setoran*') ? ' active' : '' }}"><a
                                            href="{{ route('warehouse.setoran.index') }}">Setoran</a>
                                    </li>
                                @endcan --}}
                            @can('deposit_finance_access')
                                <li class="{{ request()->is('finance/setoran*') ? ' active' : '' }}"><a
                                        href="{{ route('finance.setoran.index') }}">Setoran</a>
                                </li>
                            @endcan
                            @can('debt_finance_access')
                                <li class="{{ request()->is('finance/hutang-piutang*') ? ' active' : '' }}"><a
                                        href="{{ route('finance.hutang-piutang.index') }}">Hutang Piutang</a>
                                </li>
                            @endcan
                            @can('debt_warehouse_access')
                                <li class="{{ request()->is('gudang/hutang-piutang*') ? ' active' : '' }}"><a
                                        href="{{ route('warehouse.hutang-piutang.index') }}">Hutang Piutang</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('data_outlet_access')
                    <li
                        class="{{ request()->is('gudang/persediaan-outlet*', 'gudang/penjualan-outlet*') ? ' active open' : '' }}">
                        <a href=""><i data-feather="clipboard"></i>
                            <span>Data Outlet</span><i class="accordion-icon fa fa-angle-left"></i></a>
                        <ul class="sub-menu" style="display: block;">
                            @can('inventory_alloutlet_access')
                                <li class="{{ request()->is('gudang/persediaan-outlet*') ? ' active' : '' }}">
                                    <a href="{{ route('warehouse.persediaan-outlet.index') }}">Data Persediaan</a>
                                </li>
                            @endcan
                            @can('data_sales_all_outlets')
                                <li class="{{ request()->is('gudang/penjualan-outlet*') ? ' active' : '' }}">
                                    <a href="{{ route('warehouse.penjualan-outlet.index') }}">Data Penjualan</a>
                                </li>
                            @endcan
                        </ul>

                    </li>
                @endcan
                @can('report_access')
                    <li
                        class="{{ request()->is('gudang/laporan-pembelian*', 'gudang/laporan-distribusi*', 'finance/laporan-distribusi*', 'finance/laporan-pembelian*', 'finance/laporan-setoran*', 'finance/laporan-jurnal-kas*', 'finance/deposit/*/detail/*', 'finance/purchase/*/detail/*', 'finance/distribution/*/detail/*', 'finance/cash-journal/*/detail/*', 'finance/laporan-penjualan*', 'finance/laporan-kekayaan-outlet*', 'outlet/laporan-penjualan/*', 'outlet/transaction/*', 'outlet/laporan-penjualan*') ? ' active open' : '' }}">

                        <a href=""><i data-feather="clipboard"></i>
                            <span>Laporan</span><i class="accordion-icon fa fa-angle-left"></i></a>
                        <ul class="sub-menu" style="display: block;">

                            @can('distribution_warehouse_report_access')
                                <li class="{{ request()->is('gudang/laporan-distribusi*') ? ' active' : '' }}"><a
                                        href="{{ route('warehouse.laporan-distribusi.index') }}">Laporan Distribusi</a>
                                </li>
                            @endcan
                            @can('purchase_warehouse_report_access')
                                <li class="{{ request()->is('gudang/laporan-pembelian*') ? ' active' : '' }}"><a
                                        href="{{ route('warehouse.laporan-pembelian.index') }}">Laporan Pembelian</a>
                                </li>
                            @endcan
                            @can('distribution_finance_report_access')
                                <li
                                    class="{{ request()->is('finance/laporan-distribusi*', 'finance/distribution/*/detail/*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-distribusi.index') }}">Laporan Distribusi</a>
                                </li>
                            @endcan

                            @can('purchase_finance_report_access')
                                <li
                                    class="{{ request()->is('finance/laporan-pembelian*', 'finance/purchase/*/detail/*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-pembelian.index') }}">Laporan Pembelian</a>
                                </li>
                            @endcan
                            @can('deposit_finance_report_access')
                                <li
                                    class="{{ request()->is('finance/laporan-setoran*', 'finance/deposit/*/detail/*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-setoran.index') }}">Laporan Setoran</a>
                                </li>
                            @endcan
                            @can('cash_journal_finance_report_access')
                                <li
                                    class="{{ request()->is('finance/laporan-jurnal-kas*', 'finance/cash-journal/*/detail/*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-jurnal-kas.index') }}">Laporan Jurnal Kas</a>
                                </li>
                            @endcan
                            @can('transaction_finance_report_access')
                                <li
                                    class="{{ request()->is('finance/laporan-penjualan*', 'finance/cash-journal/*/detail/*') && !request()->is('finance/laporan-penjualan-product*') && !request()->is('finance/laporan-penjualan-bahan*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-penjualan.index') }}">Laporan Penjualan Outlet</a>
                                </li>
                            @endcan
                            @can('transaction_outlet_report_access')
                                <li
                                    class="{{ request()->is('outlet/laporan-penjualan*', 'outlet/transaction/*') ? ' active' : '' }}">
                                    <a href="{{ route('outlet.laporan-penjualan.index') }}">Laporan Penjualan</a>
                                </li>
                            @endcan
                            @can('product_sales_report_access')
                                <li class="{{ request()->is('finance/laporan-penjualan-product*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-penjualan-product.index') }}">Laporan Penjualan
                                        Produk</a>
                                </li>
                            @endcan
                            @can('material_sales_report_access')
                                <li class="{{ request()->is('finance/laporan-penjualan-bahan*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-penjualan-bahan.index') }}">Laporan Penjualan
                                        Bahan</a>
                                </li>
                            @endcan
                            @can('wealth_report_access')
                                <li class="{{ request()->is('finance/laporan-kekayaan-outlet*') ? ' active' : '' }}">
                                    <a href="{{ route('finance.laporan-kekayaan-outlet.index') }}">Laporan Kekayaan Outlet</a>
                                </li>
                            @endcan
                            @can('log_access')
                                <li class="{{ request()->is('admin/laporan-aktivitas*') ? ' active' : '' }}">
                                    <a href="{{ route('admin.log.index') }}">Laporan Aktivitas</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('master_data_access')
                    <li
                        class="{{ request()->is('admin/data-satuan*', 'admin/data-bahan*', 'admin/produk*', 'admin/biaya*', 'admin/suppliers*', 'admin/persediaan-outlet*', 'admin/event*', 'admin/reward*') ? ' active open' : '' }}">

                        <a href=""><i data-feather="settings"></i>
                            <span>Master Data</span><i class="accordion-icon fa fa-angle-left"></i></a>
                        <ul class="sub-menu" style="display: block;">
                            @can('unit_data_access')
                                <li class="{{ request()->is('admin/data-satuan*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.data-satuan.index') }}">Data Satuan</a>
                                </li>
                            @endcan
                            @can('material_data_access')
                                <li class="{{ request()->is('admin/data-bahan*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.data-bahan.index') }}">Data Bahan</a>
                                </li>
                            @endcan
                            @can('product_access')
                                <li class="{{ request()->is('admin/produk*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.produk.index') }}">Data Produk</a>
                                </li>
                            @endcan
                            @can('cost_access')
                                <li class="{{ request()->is('admin/biaya*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.biaya.index') }}">Biaya Biaya</a>
                                </li>
                            @endcan
                            @can('supplier_access')
                                <li class="{{ request()->is('admin/suppliers*') ? ' active' : '' }}"><a
                                        href="{{ route('warehouse.suppliers.index') }}">Supplier</a>
                                </li>
                            @endcan
                            @if (Auth::user()->roles[0]->title === 'Admin')
                                <li class="{{ request()->is('admin/persediaan-outlet*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.persediaan-outlet.index') }}">Data Persediaan Outlet</a>
                                </li>
                            @endif
                            @can('event_access')
                                <li class="{{ request()->is('admin/event*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.event.index') }}">Data Event</a>
                                </li>
                            @endcan
                            @can('reward_access')
                                <li class="{{ request()->is('admin/reward*') ? ' active' : '' }}">
                                    <a href="{{ route('admin.reward.index') }}">Data Reward/Hadiah</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_management_access')
                    <li
                        class="{{ request()->is('admin/permissions*', 'admin/roles*', 'admin/users*', 'admin/manajemen-gudang*', 'admin/manajemen-outlet*') ? 'open active' : '' }}">
                        <a href=""><i data-feather="user"></i>
                            <span>Manajemen User</span><i class="accordion-icon fa fa-angle-left"></i></a>
                        <ul class="sub-menu" style="display: block;">
                            @can('permission_access')
                                <li class="{{ request()->is('admin/permissions*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.permissions.index') }}">Daftar Izin</a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="{{ request()->is('admin/roles*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.roles.index') }}">Role</a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="{{ request()->is('admin/users*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.users.index') }}">{{ trans('cruds.user.title') }}</a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="{{ request()->is('admin/manajemen-gudang*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.manajemen-gudang.index') }}">Manajemen Gudang</a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="{{ request()->is('admin/manajemen-outlet*') ? ' active' : '' }}"><a
                                        href="{{ route('admin.manajemen-outlet.index') }}">Manajemen Outlet</a>
                                </li>
                            @endcan
                        </ul>

                    </li>
                @endcan

            </ul>
        </div>
    </div>
    <!--/ Sidebar Menu End -->
    <!--================================-->
    <!-- Sidebar Footer Start -->
    <!--================================-->

    <!--/ Sidebar Footer End -->
</div>
