<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/logo.png') }}"
                        class="logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="dark-logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                        class="logo-2" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                        class="dark-logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
            <form action="{{ route('searchForm') }}" method="get"
                class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
                <input class="form-control" placeholder="{{ __('layout.header.search') }}" type="text"
                    name="title">
                <button class="btn" type="submit"><i class="fas fa-search d-none d-md-block"></i></button>
            </form>
        </div>
        <div class="main-header-right">
            <ul class="nav">
                <li class="">
                    <div class="dropdown  nav-itemd-none d-md-flex">
                        <a href="lang\en" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown"
                            aria-expanded="false">
                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img
                                    src="{{ URL::asset('assets/img/flags/languages.png') }}" alt="img"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow " x-placement="bottom-end">
                            <a href="\lang\en"
                                class="dropdown-item d-flex @if (Session::get('locale') == 'en') active @endif">
                                <span class="avatar  ml-3 align-self-center bg-transparent"><img
                                        src="{{ URL::asset('assets/img/flags/us_flag.jpg') }}" alt="img"></span>
                                <div class="d-flex">
                                    <span class="mt-2">English</span>
                                </div>
                            </a>
                            <a href="\lang\ar"
                                class="dropdown-item d-flex @if (Session::get('locale') == 'ar') active @endif">
                                <span class="avatar  ml-3 align-self-center bg-transparent"><img
                                        src="{{ URL::asset('assets/img/flags/egypt_flag.png') }}"
                                        alt="img"></span>
                                <div class="d-flex">
                                    <span class="mt-2">Arabic</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
            @guest
                <div class="nav nav-item  navbar-nav-right ml-auto">
                    <a href="{{ url('/', $page = 'login') }}"
                        class="btn btn-outline-secondary nav-item mr-2 ">{{ __('layout.header.login') }}</a>
                    <a href="{{ url('/', $page = 'register') }}"
                        class="btn btn-success nav-item mr-2 ">{{ __('layout.header.register') }}</a>
                </div>
            @endguest
            @auth
                <div class="nav nav-item  navbar-nav-right ml-auto">
                    <div class="dropdown nav-item main-header-notification">
                        <a class="new nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-bell">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            @if (Auth::user()->unreadNotifications->count() !== 0)
                                <span class=" pulse"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu">
                            <div class="menu-header-content bg-primary text-right">
                                <div class="d-flex">
                                    <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">
                                        {{ __('layout.header.notfiy') }}
                                    </h6>
                                    @if (Auth::user()->unreadNotifications->count() !== 0)
                                        <a href="{{ route('notifReadAll') }}"><span
                                                class="badge badge-pill badge-warning mr-auto my-auto float-left">{{ __('layout.header.notfiy.markRead') }}</span></a>
                                    @endif
                                </div>
                                <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
                                    {{ __('layout.header.notfiy.unRead', ['count' => Auth::user()->unreadNotifications->count()]) }}
                                </p>
                            </div>
                            <div class="main-notification-list Notification-scroll">
                                @foreach (Auth::user()->unreadNotifications->take(5) as $notification)
                                    <?php
                                    $article = \App\Models\Article::where('id', $notification->data['id_article'])->first();
                                    ?>
                                    <a class="d-flex p-3 border-bottom"
                                        href="{{ route('read', ['user' => $article->id_user, 'id' => $article->id]) }}">
                                        <div class="notifyimg bg-primary">
                                            <i class="la la-check-circle text-white"></i>
                                        </div>
                                        <div class="mr-3">
                                            <h5 class="notification-label mb-1">
                                                {{ \Str::limit($article->title, 15) }}
                                            </h5>
                                            <div class="notification-subtext">
                                                {{ \App\Models\User::where('id', $notification->data['id_author'])->first()->name }}
                                                || {{ $notification->created_at }}
                                            </div>
                                        </div>
                                        <div class="mr-auto">
                                            <i class="las la-angle-left text-left text-muted"></i>
                                        </div>
                                    </a>
                                @endforeach
                                @if (Auth::user()->unreadNotifications->count() === 0)
                                    <p class="p-2 m-0 text-center" style="font-weight: bold; font-style: italic;">
                                        {{ __('layout.header.notfiy.notHave') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a href="{{ url('article/write') }}" class="btn"><i class="typcn typcn-document-add"
                                style="font-size: 1.35rem"></i></a>
                    </div>
                    <div class="dropdown main-profile-menu nav nav-item nav-link">
                        <a class="profile-user d-flex" href=""><img alt=""
                                src="{{ url('files/' . Auth::user()->img) }}"
                                onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"></a>
                        <div class="dropdown-menu">
                            <div class="main-header-profile bg-primary p-3">
                                <div class="d-flex wd-100p">
                                    <div class="main-img-user"><img alt=""
                                            src="{{ url('files/' . Auth::user()->img) }}"
                                            onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"
                                            class=""></div>
                                    <div class="mr-3 my-auto">
                                        <h6>{{ Auth::user()->name }}</h6>
                                    </div>
                                </div>
                            </div>

                            <a class="dropdown-item" href="{{ route('profile') }}"><i
                                    class="bx bx-user-circle"></i>{{ __('layout.header.ul.profile') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                <i class="bx bx-log-out"></i>{{ __('layout.header.ul.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <div class="dropdown main-header-message right-toggle">
                        <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
<!-- /main-header -->
