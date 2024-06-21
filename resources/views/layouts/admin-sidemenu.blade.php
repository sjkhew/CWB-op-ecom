<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @php $isManageProduct = (Route::is(['admin.*.product','admin.*.product.details'])) ? TRUE : FALSE; @endphp
            <li class="nav-item @if($isManageProduct == TRUE) open @endif">
                <a href="{{ route("admin.manage.product") }}" class="nav-link @if($isManageProduct == TRUE) active @endif">
                    <i class="nav-icon fas fa-fw fa-box-open">

                    </i>
                    {{ trans('global.manage_product') }}
                </a>
            </li>
            @php $isManageOrder = (Route::is(['admin.manage.order.*'])) ? TRUE : FALSE; @endphp
            <li class="nav-item" @if($isManageOrder == TRUE) open @endif">
                <a href="{{ route("admin.manage.order") }}" class="nav-link @if($isManageOrder == TRUE) active @endif">
                    <i class="nav-icon fas fa-fw fa-file-invoice-dollar">

                    </i>
                    {{ trans('global.manage_order') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.manage.misc") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-ellipsis-h">

                    </i>
                    {{ trans('global.misc') }}
                </a>
            </li>

            {{-- <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-fw fa-cogs">

                    </i>
                    {{ trans('global.misc_title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-fw fa-users">

                            </i>
                            {{ trans('global.email_list_title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-fw fa-envelope">

                            </i>
                            {{ trans('global.alert_calming_msg') }}
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key nav-icon">
                            </i>
                            {{ trans('global.change_password') }}
                        </a>
                    </li>
                @endcan
            @endif --}}

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
