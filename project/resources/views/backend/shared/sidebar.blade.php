<?php 
    $sidebarActive = trim($__env->yieldContent('sidebarActive'));
    $user = Auth::user();
?>

<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="/">
            <img alt="Logo" src="{{ URL::asset('assets/media/logos/default-dark.svg') }}" class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ URL::asset('assets/media/logos/default-small.svg') }}" class="h-20px app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>

    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a class="menu-link {!! $sidebarActive == 'home' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/dashboard' ))}}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-gauge"></i>
                        </span>
                        <span class="menu-title">{{ __('main.dashboard') }}</span>
                    </a>
                </div>

                @if ($user->can('room-type-list') || $user->can('facility-list') || $user->can('extra-charge-list') || $user->can('room-list') )
                    <div data-kt-menu-trigger="click" class="menu-item {{ in_array($sidebarActive, ['room-type','facility','extra-charge', 'room']) ? 'here show menu-accordion' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link ">
                            <span class="menu-icon">
                                <i class="fa-solid fa-server"></i>
                            </span>
                            <span class="menu-title">{{__('main.master_data')}}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--begin:Menu sub-->
                        @if ($user->can('room-type-list'))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {!! $sidebarActive == 'room-type' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/room-type' ))}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('main.room-type') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <!--begin:Menu sub-->
                        @if ($user->can('facility-list'))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {!! $sidebarActive == 'facility' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/facility' ))}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('main.facility') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <!--begin:Menu sub-->
                        @if ($user->can('extra-charge-list'))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {!! $sidebarActive == 'extra-charge' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/extra-charge' ))}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('main.extra-charge') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($user->can('room-list'))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {!! $sidebarActive == 'room' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/room' ))}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('main.room') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>                
                @endif

                @if ($user->can('transaction-list'))
                    <div class="menu-item">
                        <a class="menu-link {!! $sidebarActive == 'transaction' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/transaction' ))}}">
                            <span class="menu-icon">
                                <i class="fa fa-table"></i>
                            </span>
                            <span class="menu-title">{{ __('main.transaction') }}</span>
                        </a>
                    </div>
                @endif

                @if ($user->can('report-list'))
                    <div data-kt-menu-trigger="click" class="menu-item {{ in_array($sidebarActive, ['transaction-report','product-report']) ? 'here show menu-accordion' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link ">
                            <span class="menu-icon">
                                <i class="fa-solid fa-chart-pie"></i>
                            </span>
                            <span class="menu-title">{{__('main.report')}}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {!! $sidebarActive == 'transaction-report' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/report/transaction' ))}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('main.transaction-report') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>                
                @endif

                @if ($user->can('users-list') || $user->can('roles-list') || $user->can('group_user-list') )
                    <div data-kt-menu-trigger="click" class="menu-item {{ in_array($sidebarActive, ['users', 'group_user', 'roles']) ? 'here show menu-accordion' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link ">
                            <span class="menu-icon">
                            <i class="fa fa-user-lock"></i>
                            </span>
                            <span class="menu-title">{{__('main.user_access')}}</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--begin:Menu sub-->
                        @if ($user->can('users-list'))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {!! $sidebarActive == 'users' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/user_access/user' ))}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('main.user_list') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($user->can('roles-list'))
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {!! $sidebarActive == 'roles' ? ' active' : '' !!}" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'admin/user_access/role' ))}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ __('main.user_role') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>                
                @endif
            </div>
        </div>
    </div>
</div>

