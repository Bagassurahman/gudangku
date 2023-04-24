<div class="page-sidebar">
    <div class="logo">
        <a class="logo-img" href="index.html">
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
                <li class="{{ request()->is('admin') ? ' active' : '' }}">
                    <a href="{{ route('admin.home') }}"><i data-feather="layout"></i>
                        <span>Dashboard</span></a>
                </li>
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
                @can('master_data_access')
                    <li
                        class="{{ request()->is('admin/data-satuan*', 'admin/data-bahan*', 'admin/produk*', 'admin/biaya*', 'admin/suppliers*') ? ' active open' : '' }}">

                        <a href=""><i data-feather="home"></i>
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
