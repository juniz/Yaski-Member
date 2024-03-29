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

                {{-- <li class="menu-title" data-key="t-apps">Pendaftaran</li>

                <li>
                    @can('view workshop')
                    <a href="/workshop">
                        <i data-feather="mail"></i>
                        <span data-key="t-email">Workshop</span>
                    </a>
                    @endcan
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="apps-email-inbox" data-key="t-inbox">@lang('translation.Inbox')</a></li>
                        <li><a href="apps-email-read" data-key="t-read-email">@lang('translation.Read_Email')</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="apps-chat">
                        <i data-feather="message-square"></i>
                        <span data-key="t-chat">@lang('translation.Chat')</span>
                    </a>
                </li> --}}

                <li class="menu-title" data-key="t-apps">Pendaftaran</li>
                <li>
                    <a href="/workshop">
                        <i data-feather="calendar"></i>
                        <span data-key="t-workshop">Workshop</span>
                    </a>
                </li>

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

                {{-- <li>
                    <a href="apps-calendar">
                        <i data-feather="calendar"></i>
                        <span data-key="t-calendar">@lang('translation.Calendars')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-contacts">@lang('translation.Contacts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="apps-contacts-grid" data-key="t-user-grid">@lang('translation.User_Grid')</a></li>
                        <li><a href="apps-contacts-list" data-key="t-user-list">@lang('translation.User_List')</a></li>
                        <li><a href="apps-contacts-profile" data-key="t-profile">@lang('translation.Profile')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="trello"></i>
                        <span data-key="t-tasks">@lang('translation.Tasks')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="tasks-list" key="t-task-list">@lang('translation.Task_List')</a></li>
                        <li><a href="tasks-kanban" key="t-kanban-board">@lang('translation.Kanban_Board')</a></li>
                        <li><a href="tasks-create" key="t-create-task">@lang('translation.Create_Task')</a></li>
                    </ul>
                </li>

                <li class="menu-title" data-key="t-pages">@lang('translation.Pages')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="layers"></i>
                        <span data-key="t-authentication">@lang('translation.Authentication')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login" data-key="t-login">@lang('translation.Login')</a></li>
                        <li><a href="auth-register" data-key="t-register">@lang('translation.Register')</a></li>
                        <li><a href="auth-recoverpw"
                                data-key="t-recover-password">@lang('translation.Recover_Password')</a></li>
                        <li><a href="auth-lock-screen" data-key="t-lock-screen">@lang('translation.Lock_Screen')</a>
                        </li>
                        <li><a href="auth-logout" data-key="t-logout">@lang('translation.Logout')</a></li>
                        <li><a href="auth-confirm-mail" data-key="t-confirm-mail">@lang('translation.Confirm_Mail')</a>
                        </li>
                        <li><a href="auth-email-verification"
                                data-key="t-email-verification">@lang('translation.Email_verification')</a></li>
                        <li><a href="auth-two-step-verification"
                                data-key="t-two-step-verification">@lang('translation.Two_step_verification')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">@lang('translation.Pages')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter" key="t-starter-page">@lang('translation.Starter_Page')</a></li>
                        <li><a href="pages-maintenance" key="t-maintenance">@lang('translation.Maintenance')</a></li>
                        <li><a href="pages-comingsoon" key="t-coming-soon">@lang('translation.Coming_Soon')</a></li>
                        <li><a href="pages-timeline" key="t-timeline">@lang('translation.Timeline')</a></li>
                        <li><a href="pages-faqs" key="t-faqs">@lang('translation.FAQs')</a></li>
                        <li><a href="pages-pricing" key="t-pricing">@lang('translation.Pricing')</a></li>
                        <li><a href="pages-404" key="t-error-404">@lang('translation.Error_404')</a></li>
                        <li><a href="pages-500" key="t-error-500">@lang('translation.Error_500')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="layouts-horizontal">
                        <i data-feather="layout"></i>
                        <span data-key="t-horizontal">@lang('translation.Horizontal')</span>
                    </a>
                </li>

                <li class="menu-title mt-2" data-key="t-components">@lang('translation.Components')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="briefcase"></i>
                        <span data-key="t-components">@lang('translation.Bootstrap')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="ui-alerts" key="t-alerts">@lang('translation.Alerts')</a></li>
                        <li><a href="ui-buttons" key="t-buttons">@lang('translation.Buttons')</a></li>
                        <li><a href="ui-cards" key="t-cards">@lang('translation.Cards')</a></li>
                        <li><a href="ui-carousel" key="t-carousel">@lang('translation.Carousel')</a></li>
                        <li><a href="ui-dropdowns" key="t-dropdowns">@lang('translation.Dropdowns')</a></li>
                        <li><a href="ui-grid" key="t-grid">@lang('translation.Grid')</a></li>
                        <li><a href="ui-images" key="t-images">@lang('translation.Images')</a></li>
                        <li><a href="ui-modals" key="t-modals">@lang('translation.Modals')</a></li>
                        <li><a href="ui-offcanvas" key="t-offcanvas">@lang('translation.Offcanvas')</a></li>
                        <li><a href="ui-progressbars" key="t-progress-bars">@lang('translation.Progress_Bars')</a></li>
                        <li><a href="ui-placeholders" key="t-placeholders">@lang('translation.Placeholders')</a></li>
                        <li><a href="ui-tabs-accordions"
                                key="t-tabs-accordions">@lang('translation.Tabs_&_Accordions')</a></li>
                        <li><a href="ui-typography" key="t-typography">@lang('translation.Typography')</a></li>
                        <li><a href="ui-video" key="t-video">@lang('translation.Video')</a></li>
                        <li><a href="ui-general" key="t-general">@lang('translation.General')</a></li>
                        <li><a href="ui-colors" key="t-colors">@lang('translation.Colors')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="gift"></i>
                        <span data-key="t-ui-elements">@lang('translation.Extended')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="extended-lightbox" data-key="t-lightbox">@lang('translation.Lightbox')</a></li>
                        <li><a href="extended-rangeslider"
                                data-key="t-range-slider">@lang('translation.Range_Slider')</a></li>
                        <li><a href="extended-sweet-alert" data-key="t-sweet-alert">@lang('translation.Sweet_Alert')
                                2</a></li>
                        <li><a href="extended-session-timeout"
                                data-key="t-session-timeout">@lang('translation.Session_Timeout')</a></li>
                        <li><a href="extended-rating" data-key="t-rating">@lang('translation.Rating')</a></li>
                        <li><a href="extended-notifications"
                                data-key="t-notifications">@lang('translation.Notifications')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);">
                        <i data-feather="box"></i>
                        <span class="badge rounded-pill bg-soft-danger text-danger float-end">7</span>
                        <span data-key="t-forms">@lang('translation.Forms')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="form-elements" data-key="t-form-elements">@lang('translation.Basic_Elements')</a>
                        </li>
                        <li><a href="form-validation" data-key="t-form-validation">@lang('translation.Validation')</a>
                        </li>
                        <li><a href="form-advanced" data-key="t-form-advanced">@lang('translation.Advanced_Plugins')</a>
                        </li>
                        <li><a href="form-editors" data-key="t-form-editors">@lang('translation.Editors')</a></li>
                        <li><a href="form-uploads" data-key="t-form-upload">@lang('translation.File_Upload')</a></li>
                        <li><a href="form-wizard" data-key="t-form-wizard">@lang('translation.Wizard')</a></li>
                        <li><a href="form-mask" data-key="t-form-mask">@lang('translation.Mask')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="sliders"></i>
                        <span data-key="t-tables">@lang('translation.Tables')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="tables-basic" data-key="t-basic-tables">@lang('translation.Bootstrap_Basic')</a>
                        </li>
                        <li><a href="tables-datatable" data-key="t-data-tables">@lang('translation.Data_Tables')</a>
                        </li>
                        <li><a href="tables-responsive"
                                data-key="t-responsive-table">@lang('translation.Responsive')</a></li>
                        <li><a href="tables-editable"
                                data-key="t-editable-table">@lang('translation.Editable_Table')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="pie-chart"></i>
                        <span data-key="t-charts">@lang('translation.Charts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="charts-apex" data-key="t-apex-charts">@lang('translation.Apex_Charts')</a></li>
                        <li><a href="charts-echart" data-key="t-e-charts">@lang('translation.E_Charts')</a></li>
                        <li><a href="charts-chartjs" data-key="t-chartjs-charts">@lang('translation.Chartjs')</a></li>
                        <li><a href="charts-knob" data-key="t-knob-charts">@lang('translation.Jquery_Knob')</a></li>
                        <li><a href="charts-sparkline" data-key="t-sparkline-charts">@lang('translation.Sparkline')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="cpu"></i>
                        <span data-key="t-icons">@lang('translation.Icons')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="icons-feather" data-key="t-feather">@lang('translation.Feather')</a></li>
                        <li><a href="icons-boxicons" data-key="t-boxicons">@lang('translation.Boxicons')</a></li>
                        <li><a href="icons-materialdesign"
                                data-key="t-material-design">@lang('translation.Material_Design')</a></li>
                        <li><a href="icons-dripicons" data-key="t-dripicons">@lang('translation.Dripicons')</a></li>
                        <li><a href="icons-fontawesome" data-key="t-font-awesome">@lang('translation.Font_awesome')
                                5</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="map"></i>
                        <span data-key="t-maps">@lang('translation.Maps')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="maps-google" data-key="t-g-maps">@lang('translation.Google')</a></li>
                        <li><a href="maps-vector" data-key="t-v-maps">@lang('translation.Vector')</a></li>
                        <li><a href="maps-leaflet" data-key="t-l-maps">@lang('translation.Leaflet')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="share-2"></i>
                        <span data-key="t-multi-level">@lang('translation.Multi_Level')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);" data-key="t-level-1-1">@lang('translation.Level_1.1')</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow"
                                data-key="t-level-1-2">@lang('translation.Level_1.2')</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);"
                                        data-key="t-level-2-1">@lang('translation.Level_2.1')</a></li>
                                <li><a href="javascript: void(0);"
                                        data-key="t-level-2-2">@lang('translation.Level_2.2')</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}

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