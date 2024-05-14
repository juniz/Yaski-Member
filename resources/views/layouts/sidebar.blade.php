<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    @can('view profile')
                    <a href="/profile">
                        <i data-feather="user"></i>
                        <span data-key="t-dashboard">Profile</span>
                    </a>
                    @endcan
                </li>

                @can('view member')
                <li class="menu-title" data-key="t-apps">Pengaturan</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow"> 
                        <i data-feather="lock"></i>
                        <span data-key="t-ecommerce">Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('view member')
                        <li><a href="members" key="t-products">Pengguna</a></li>
                        @endcan
                        @can('view role')
                        <li><a href="roles" data-key="t-product-detail">Role</a></li>
                        @endcan
                        @can('view permission')
                        <li><a href="permissions" data-key="t-orders">Permission</a></li>
                        @endcan
                        @can('view permintaan workshop')
                        <li>
                            <a href="/list-workshop">
                                <i data-feather="calendar"></i>
                                <span data-key="t-setting-workshop">Workshop</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                <li class="menu-title" data-key="t-apps">Pendaftaran</li>
                <li>
                    <a href="/workshop">
                        <i data-feather="calendar"></i>
                        <span data-key="t-workshop">Workshop</span>
                    </a>
                </li>

                @can('view paklaring')
                <li class="menu-title" data-key="t-apps">Permintaan</li>

                <li>
                    @can('view paklaring')
                    <a href="/paklaring">
                        <i data-feather="archive"></i>
                        <span data-key="t-paklaring">Paklaring</span>
                    </a>
                    @endcan
                    @can('view permintaan mou')
                    <a href="/mou">
                        <i data-feather="clipboard"></i>
                        <span data-key="t-mou">MOU</span>
                    </a>
                    @endcan
                    {{-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="apps-email-inbox" data-key="t-inbox">@lang('translation.Inbox')</a></li>
                        <li><a href="apps-email-read" data-key="t-read-email">@lang('translation.Read_Email')</a></li>
                    </ul> --}}
                </li>
                @endcan

                
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