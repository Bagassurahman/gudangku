<div id="sidebar-disable" class="sidebar-disable hidden"></div>

<div id="sidebar" class="sidebar-menu transform -translate-x-full ease-in">
    <div class="flex items-center justify-center mt-4">
        <div class="flex items-center">
            <span class="text-white text-2xl mx-2 font-semibold">{{ trans('panel.site_title') }}</span>
        </div>
    </div>
    <nav class="mt-4">
        <a class="nav-link{{ request()->is('admin') ? ' active' : '' }}" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt">

            </i>

            <span class="mx-4">Dashboard</span>
        </a>
        @can('inventory_access')
            <a class="nav-link{{ request()->is('gudang/persediaan*') ? ' active' : '' }}"
                href="{{ route('warehouse.persediaan.index') }}">
                <i class="fas fa fa-cubes">

                </i>

                <span class="mx-4">Persediaan</span>
            </a>
        @endcan
        @can('distribution_access')
            <a class="nav-link{{ request()->is('gudang/distribusi*') ? ' active' : '' }}"
                href="{{ route('warehouse.distribusi.index') }}">
                <i class="fas fa fa-cubes">

                </i>

                <span class="mx-4">Distribusi</span>
            </a>
        @endcan
        @can('transaction_access')
            <div class="nav-dropdown">
                <a class="nav-link" href="#">
                    <i class="fa-fw fas fa-credit-card">

                    </i>

                    <span class="mx-4">Transaksi</span>
                    <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                </a>

            </div>
        @endcan
        @can('master_data_access')
            <div class="nav-dropdown">
                <a class="nav-link" href="#">
                    <i class="fa-fw fas fa-cogs">

                    </i>

                    <span class="mx-4">Master Data</span>
                    <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                </a>
                <div class="dropdown-items mb-1 hidden">
                    @can('unit_data_access')
                        <a class="nav-link{{ request()->is('admin/data-satuan*') ? ' active' : '' }}"
                            href="{{ route('admin.data-satuan.index') }}">
                            <i class="fa-fw fas fa-database">

                            </i>

                            <span class="mx-4">Data Satuan</span>
                        </a>
                    @endcan
                    @can('material_data_access')
                        <a class="nav-link{{ request()->is('admin/data-bahan*') ? ' active' : '' }}"
                            href="{{ route('admin.data-bahan.index') }}">
                            <i class="fa-fw fas fa-cubes">

                            </i>

                            <span class="mx-4">Data Bahan</span>
                        </a>
                    @endcan
                    @can('cost_access')
                        <a class="nav-link{{ request()->is('admin/biaya*') ? ' active' : '' }}"
                            href="{{ route('admin.biaya.index') }}">
                            <i class="fa-fw fas fa-credit-card">

                            </i>

                            <span class="mx-4">Biaya Biaya</span>
                        </a>
                    @endcan
                    @can('supplier_access')
                        <a class="nav-link{{ request()->is('gudang/supplier*') ? ' active' : '' }}"
                            href="{{ route('warehouse.suppliers.index') }}">
                            <i class="fa-fw fas fa-cubes">

                            </i>

                            <span class="mx-4">Data Supplier</span>
                        </a>
                    @endcan
                </div>
            </div>
        @endcan
        @can('user_management_access')
            <div class="nav-dropdown">
                <a class="nav-link" href="#">
                    <i class="fa-fw fas fa-users">

                    </i>

                    <span class="mx-4">{{ trans('cruds.userManagement.title') }}</span>
                    <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                </a>
                <div class="dropdown-items mb-1 hidden">
                    @can('permission_access')
                        <a class="nav-link{{ request()->is('admin/permissions*') ? ' active' : '' }}"
                            href="{{ route('admin.permissions.index') }}">
                            <i class="fa-fw fas fa-unlock-alt">

                            </i>

                            <span class="mx-4">{{ trans('cruds.permission.title') }}</span>
                        </a>
                    @endcan
                    @can('role_access')
                        <a class="nav-link{{ request()->is('admin/roles*') ? ' active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                            <i class="fa-fw fas fa-briefcase">

                            </i>

                            <span class="mx-4">{{ trans('cruds.role.title') }}</span>
                        </a>
                    @endcan
                    @can('user_access')
                        <a class="nav-link{{ request()->is('admin/users*') ? ' active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="fa-fw fas fa-user">

                            </i>

                            <span class="mx-4">{{ trans('cruds.user.title') }}</span>
                        </a>
                    @endcan
                    @can('user_access')
                        <a class="nav-link{{ request()->is('admin/manajemen-gudang*') ? ' active' : '' }}"
                            href="{{ route('admin.manajemen-gudang.index') }}">
                            <i class="fa-fw fas fa-user">
                            </i>
                            <span class="mx-4">Manajemen Gudag</span>
                        </a>
                    @endcan
                    @can('user_access')
                        <a class="nav-link{{ request()->is('admin/manajemen-outlet*') ? ' active' : '' }}"
                            href="{{ route('admin.manajemen-outlet.index') }}">
                            <i class="fa-fw fas fa-user">
                            </i>
                            <span class="mx-4">Manajemen Outlet</span>
                        </a>
                    @endcan
                </div>
            </div>
        @endcan

        @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            <a class="nav-link{{ request()->is('profile/password') ? ' active' : '' }}"
                href="{{ route('profile.password.edit') }}">
                <i class="fa-fw fas fa-key">

                </i>

                <span class="mx-4">{{ trans('global.change_password') }}</span>
            </a>
        @endif
        <a class="nav-link" href="#"
            onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            <i class="fa-fw fas fa-sign-out-alt">

            </i>

            <span class="mx-4">{{ trans('global.logout') }}</span>
        </a>
    </nav>
</div>
