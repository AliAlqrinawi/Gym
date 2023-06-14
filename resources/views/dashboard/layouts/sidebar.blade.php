<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="index.html"><img
                    src="{{ asset('dashboard/img/brand/logo-light.png') }}" class="main-logo" alt="logo"></a>
            <a class="desktop-logo logo-dark active" href="index.html"><img
                    src="{{ asset('dashboard/img/brand/logo-light.png') }}" class="main-logo" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-light active" href="index.html"><img
                    src="{{ asset('dashboard/img/brand/logo-light.png') }}" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-dark active" href="index.html"><img
                    src="{{ asset('dashboard/img/brand/logo-light.png') }}" alt="logo"></a>
        </div>
        <div class="main-sidemenu">
            <div class="app-sidebar__user clearfix">
                <div class="dropdown user-pro-body">
                    <div class="main-img-user avatar-xl">
                        <img alt="user-img" src="{{ asset('dashboard/img/users/6.jpg') }}"><span
                            class="avatar-status profile-status bg-green"></span>
                    </div>
                    <div class="user-info">
                        <h4 class="fw-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
                        <span class="mb-0 text-muted">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">
                <li class="side-item side-item-category">{{ __('Main') }}</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('home') }}">
                        <img class="side-menu__icon mCS_img_loaded"
                        src="https://img.icons8.com/fluency/48/000000/dashboard-layout.png"
                        style=" width: 30px; height: 30px;">
                        <span class="side-menu__label">{{ __('Home') }}</span><span
                            class="badge bg-success text-light bg-side-text">1</span></a>
                </li>
                <li class="side-item side-item-category">{{ __('General') }}</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('role.index') }}">
                        <img class="side-menu__icon mCS_img_loaded" src="https://img.icons8.com/nolan/344/service.png"
                        style=" width: 30px; height: 30px;">
                        <span class="side-menu__label">{{ __('Roles') }}</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <img width="30" style="margin-inline-end: 14px;"
                        src="https://img.icons8.com/?size=512&id=62186&format=png" />
                        <span class="side-menu__label">{{ __('Schedule') }}</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li><a href="#side26" class="active" data-bs-toggle="tab"><i class="fe fe-airplay"></i><p>Home</p></a></li>
                                        <li><a href="#side27" data-bs-toggle="tab"><i class="fe fe-package"></i><p>Events</p></a></li>
                                        <li><a href="#side28" data-bs-toggle="tab"><i class="fe fe-move"></i><p>Activity</p></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane tab-content-show active" id="side26">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu__label1"><a href="javascript:void(0);">{{ __('Schedule') }}</a></li>
                                            @foreach (App\Models\Table::where('is_parent' , 'parent')->with('weekDay')->get() as $value)
                                            <li class="sub-slide">
                                                <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);">
                                                    <span class="sub-side-menu__label">{{ App::getLocale() == 'en' ? $value->title_en : $value->title_ar }}</span>
                                                    <i class="sub-angle fe fe-chevron-down"></i></a>
                                                <ul class="sub-slide-menu">
                                                    <li class="sub-slide2">
                                                        @foreach ($value->weekDay as $week_day)
                                                        <a class="sub-side-menu__item" data-bs-toggle="sub-slide2"
                                                        href="{{ url(app()->getLocale().'/admin/dayTable?day='.$week_day->id) }}"><span class="sub-side-menu__label">{{ App::getLocale() == 'en' ? $week_day->title_en : $week_day->title_ar }}</span>
                                                            <i class="sub-angle2 fe fe-chevron-down"></i></a>
                                                            {{-- @foreach ($week_day->dayTable as $day_table)
                                                            <ul class="sub-slide-menu1">
                                                                <li><a class="sub-slide-item2" href="javascript:void(0);">{{ App::getLocale() == 'en' ? $day_table->title_en : $day_table->title_ar }}</a></li>
                                                            </ul>
                                                            @endforeach --}}
                                                        @endforeach
                                                    </li>
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    {{-- <div class="tab-pane tab-content-double" id="side27">
                                        <h5 class="mt-3 mb-4 tx-16">Events</h5>
                                        <div class="latest-timeline">
                                            <div class="timeline">
                                                <div class="mt-0 event-text">
                                                    <h6 class="mb-0"><a target="_blank" href="#" class="timeline-head">Employees Meeting</a></h6>
                                                    <small class="text-muted mb-2">20 Feb, 2019</small>
                                                    <p class="tx-13">sed do eiusmod tempor incididunt ut labore et. </p>
                                                </div>
                                                <div class="event-text">
                                                    <h6 class="mb-0"><a href="#" class="timeline-head">Anniversary Celebration</a></h6>
                                                    <small class="mb-2 text-muted">14 Feb, 2019</small>
                                                    <p class="tx-13">sed do eiusmod tempor  magna aliqua nisi ut. </p>
                                                </div>
                                                <div class="event-text">
                                                    <h6 class="mb-0"><a href="#" class="timeline-head">Best Employee Announcement</a></h6>
                                                    <small class="mb-2 text-muted">13 Feb, 2019</small>
                                                    <p class="tx-13">sed do eiusmod tempor incididunt ut aliquip.</p>
                                                </div>
                                                <div class="event-text">
                                                    <h6 class="mb-0"><a href="#" class="timeline-head">Weekend trip</a></h6>
                                                    <small class="mb-2 text-muted">11 Feb, 2019</small>
                                                    <p class="tx-13">sed do eiusmod tempor incididunt ut aliquip.</p>
                                                </div>
                                                <div class="event-text">
                                                    <h6 class="mb-0"><a href="#" class="timeline-head">New Project Started..</a></h6>
                                                    <small class="mb-2 text-muted">09 Feb, 2019</small>
                                                    <p class="tx-13">sed do eiusmod tempor incididunt ut aliquip.</p>
                                                </div>
                                                <div class="mb-0 event-text">
                                                    <h6 class="mb-0"><a href="#" class="timeline-head">Gradening working</a></h6>
                                                    <small class="mb-2 text-muted">02 Feb, 2019</small>
                                                    <p class="tx-13">sed do eiusmod tempor  aliqua nisi ut aliquip. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane tab-content-double" id="side28">
                                        <h5 class="mt-3 mb-4 tx-16">Activity</h5>
                                        <div class="activity mt-3 p-0">
                                            <img src="../assets/img/users/8.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Samantha Melon</b> Add a new projects <b> AngularJS Template</b></p>
                                                    <small class="text-muted ">30 mins ago</small>
                                                </div>
                                            </div>
                                            <img src="../assets/img/users/5.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Allie Grater</b> Add a new projects <b>Free HTML Template</b></p>
                                                    <small class="text-muted ">1 days ago</small>
                                                </div>
                                            </div>
                                            <img src="../assets/img/users/6.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Gabe Lackmen</b> Add a new projects <b>Free PSD Template</b></p>
                                                    <small class="text-muted ">3 days ago</small>
                                                </div>
                                            </div>
                                            <img src="../assets/img/users/7.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Abigail John</b> Add a new projects <b>Free UI Template</b></p>
                                                    <small class="text-muted ">5 days ago</small>
                                                </div>
                                            </div>
                                            <img src="../assets/img/users/14.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Jiggel mossin</b> Add a new projects <b> AngularJS Template</b></p>
                                                    <small class="text-muted ">30 mins ago</small>
                                                </div>
                                            </div>
                                            <img src="../assets/img/users/3.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Raven Chanan</b> Add a new projects <b>Free HTML Template</b></p>
                                                    <small class="text-muted ">1 days ago</small>
                                                </div>
                                            </div>
                                            <img src="../assets/img/users/1.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Anna Ogden</b> Add a new projects <b>Free PSD Template</b></p>
                                                    <small class="text-muted ">3 days ago</small>
                                                </div>
                                            </div>
                                            <img src="../assets/img/users/11.jpg" alt="" class="img-activity">
                                            <div class="time-activity">
                                                <div class="item-activity">
                                                    <p class="mb-0 tx-13"><b>Allie Grater</b> Add a new projects <b>Free UI Template</b></p>
                                                    <small class="text-muted ">5 days ago</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('table.index') }}">
                        <img width="30" style="margin-inline-end: 14px;"
                        src="https://img.icons8.com/?size=512&id=62186&format=png" />
                    <span class="side-menu__label">{{ __('Table') }}</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dayTable.index') }}">
                        <img width="30" style="margin-inline-end: 14px;"
                        src="https://img.icons8.com/?size=512&id=62186&format=png" />
                        <span class="side-menu__label">{{ __('Days') }}</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('muscle.index') }}">
                    <img width="30" style="margin-inline-end: 14px;"
                    src="https://img.icons8.com/?size=512&id=48301&format=png&color=1A6DFF,C822FF" />
                    <span class="side-menu__label">{{ __('Muscles') }}</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('video.index') }}">
                        <img width="30" style="margin-inline-end: 14px;"
                        src="https://img.icons8.com/?size=512&id=MG8AizwwWSHp&format=png&color=1A6DFF,C822FF" />
                    <span class="side-menu__label">{{ __('Videos') }}</span></a>
                </li>
                {{-- <li class="slide">
                    <a class="side-menu__item" href="{{ route('coupon.index') }}"><svg xmlns="http://www.w3.org/2000/svg"
                            class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg><span class="side-menu__label">{{ __('Coupons') }}</span></a>
                </li> --}}
                {{-- <li class="slide">
                    <a class="side-menu__item" href="{{ route('package.index') }}"><svg xmlns="http://www.w3.org/2000/svg"
                            class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg><span class="side-menu__label">{{ __('Packages') }}</span></a>
                </li> --}}
                {{-- <li class="slide">
                    <a class="side-menu__item" href="{{ route('layout.index') }}"><svg xmlns="http://www.w3.org/2000/svg"
                            class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg><span class="side-menu__label">{{ __('Layouts') }}</span></a>
                </li> --}}
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <img class="side-menu__icon mCS_img_loaded" style=" width: 30px; height: 30px;"
                        src="https://img.icons8.com/nolan/64/settings--v1.png">
                        <span class="side-menu__label">{{ __('Settings') }}</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li><a href="#side11" class="active " data-bs-toggle="tab"><i
                                                    class="fe fe-airplay"></i>
                                                <p>Home</p>
                                            </a></li>
                                        <li><a href="#side12" data-bs-toggle="tab"><i class="fe fe-package"></i>
                                                <p>Events</p>
                                            </a></li>
                                        <li><a href="#side13" data-bs-toggle="tab"><i class="fe fe-move"></i>
                                                <p>Activity</p>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane tab-content-show active" id="side11">
                                        <ul class="sidemenu-list">
                                            <li><a class="slide-item" href="{{ route('setting.index') }}">{{ __('General Settings') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane tab-content-show active" id="side11">
                                        <ul class="sidemenu-list">
                                            <li><a class="slide-item" href="{{ route('setting.index') }}">{{ __('Social Media Settings') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </aside>
</div>
