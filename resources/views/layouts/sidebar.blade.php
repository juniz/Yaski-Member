<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">
        @php
            $isAdmin = auth()->check() && auth()->user()->can('view member');
            $isAdminMenuActive = request()->is('members*')
                || request()->is('roles*')
                || request()->is('permissions*')
                || request()->is('list-workshop*')
                || request()->routeIs('inhouse-training.index');
            $isPermintaanMenuActive = request()->routeIs('paklaring.index')
                || request()->routeIs('mou.index')
                || request()->routeIs('inhouse-training.request');
        @endphp

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="{{ request()->routeIs('profile') ? 'mm-active' : '' }}">
                    @can('view profile')
                    <a href="/profile" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i data-feather="user"></i>
                        <span data-key="t-dashboard">Profile</span>
                    </a>
                    @endcan
                </li>

                @can('view member')
                <li class="menu-title" data-key="t-apps">Pengaturan</li>

                <li class="{{ $isAdminMenuActive ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow {{ $isAdminMenuActive ? 'active' : '' }}"> 
                        <i data-feather="lock"></i>
                        <span data-key="t-ecommerce">Admin</span>
                    </a>
                    <ul class="sub-menu {{ $isAdminMenuActive ? 'mm-show' : '' }}" aria-expanded="{{ $isAdminMenuActive ? 'true' : 'false' }}">
                        @can('view member')
                        <li><a href="members" class="{{ request()->is('members*') ? 'active' : '' }}" key="t-products">Pengguna</a></li>
                        @endcan
                        @can('view role')
                        <li><a href="roles" class="{{ request()->is('roles*') ? 'active' : '' }}" data-key="t-product-detail">Role</a></li>
                        @endcan
                        @can('view permission')
                        <li><a href="permissions" class="{{ request()->is('permissions*') ? 'active' : '' }}" data-key="t-orders">Permission</a></li>
                        @endcan
                        @can('view permintaan workshop')
                        <li>
                            <a href="/list-workshop" class="{{ request()->is('list-workshop*') ? 'active' : '' }}">
                                <i data-feather="calendar"></i>
                                <span data-key="t-setting-workshop">Workshop</span>
                            </a>
                        </li>
                        @endcan
                        @can('view member')
                        <li>
                            <a href="/inhouse-training" class="{{ request()->routeIs('inhouse-training.index') ? 'active' : '' }}">
                                <i data-feather="file-text"></i>
                                <span data-key="t-inhouse-training-admin">Inhouse Training</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                <li class="menu-title" data-key="t-apps">Pendaftaran</li>
                <li class="{{ request()->routeIs('workshop.list') ? 'mm-active' : '' }}">
                    <a href="/workshop" class="{{ request()->routeIs('workshop.list') ? 'active' : '' }}">
                        <i data-feather="calendar"></i>
                        <span data-key="t-workshop">Workshop</span>
                    </a>
                </li>

                @if(auth()->check())
                <li class="menu-title" data-key="t-apps">Permintaan</li>

                @can('view paklaring')
                <li class="{{ request()->routeIs('paklaring.index') ? 'mm-active' : '' }}">
                    <a href="/paklaring" class="{{ request()->routeIs('paklaring.index') ? 'active' : '' }}">
                        <i data-feather="archive"></i>
                        <span data-key="t-paklaring">Paklaring</span>
                    </a>
                </li>
                @endcan
                @can('view permintaan mou')
                <li class="{{ request()->routeIs('mou.index') ? 'mm-active' : '' }}">
                    <a href="/mou" class="{{ request()->routeIs('mou.index') ? 'active' : '' }}">
                        <i data-feather="clipboard"></i>
                        <span data-key="t-mou">MOU</span>
                    </a>
                </li>
                @endcan
                <li class="{{ request()->routeIs('inhouse-training.request') ? 'mm-active' : '' }}">
                    <a href="/inhouse-training/permintaan" class="{{ request()->routeIs('inhouse-training.request') ? 'active' : '' }}">
                        <i data-feather="file-text"></i>
                        <span data-key="t-inhouse-training">Inhouse Training</span>
                    </a>
                </li>
                @endif

                
            </ul>

            {{-- <div class="card sidebar-alert shadow-none text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                        <a href="#!" class="btn btn-primary mt-2">Upgrade Now</a>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
