@extends('layouts.master')
@section('title')
    Profile
@endsection
@section('css')
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm mt-3">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="img profile" src="{{ url('files/' . $user->img) }}"
                                    onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'">
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ $user->name }}</h5>
                                </div>
                            </div>
                            <h6>{{ __('pages.profile.info') }}</h6>
                            <div class="main-profile-bio">
                                {{ \Str::limit($user->info, 30) }}
                            </div><!-- main-profile-bio -->
                            <div class="row">
                                <div class="col-md-4 col mb20">
                                    <h5>{{ $user->followers->count() }}</h5>
                                    <h6 class="text-small text-muted mb-0">{{ __('pages.profile.followers') }}</h6>
                                </div>
                                <div class="col-md-4 col mb20">
                                    <h5>{{ $user->articles()->count() }}</h5>
                                    <h6 class="text-small text-muted mb-0">{{ __('pages.profile.articles') }}</h6>
                                </div>
                            </div>
                            @if (Auth::user()->id !== $user->id)
                                <div class="actions">
                                    @if (\Auth::user()->follow->where('id_author', $user->id)->first())
                                        <a href="{{ route('follow', ['id' => $user->id]) }}"
                                            class="btn btn-outline-primary w-100 mt-2">
                                            {{ __('pages.profile.unFollow') }}
                                        </a>
                                    @else
                                        <a href="{{ route('follow', ['id' => $user->id]) }}"
                                            class="btn btn-primary w-100 mt-2">
                                            {{ __('pages.profile.follow') }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                            <div class="text-muted">
                                {{ __('pages.profile.lastLogin') }}: {{ Auth::user()->last_login }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row row-sm">
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-primary-transparent">
                                    <i class="icon-layers text-primary"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13">{{ __('pages.profile.articles') }}</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $user->articles()->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->id == $user->id)
                    <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="counter-status d-flex md-mb-0">
                                    <div class="counter-icon bg-success-transparent">
                                        <i class="icon-rocket text-success"></i>
                                    </div>
                                    <div class="mr-auto">
                                        <h5 class="tx-13">{{ __('pages.profile.watched') }}</h5>
                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $user->articles()->sum('watched') }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="counter-status d-flex md-mb-0">
                                    <div class="counter-icon bg-danger-transparent">
                                        <i class="icon-close text-danger"></i>
                                    </div>
                                    <div class="mr-auto">
                                        <h5 class="tx-13">{{ __('pages.profile.reports') }}</h5>
                                        <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $user->reports }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="active">
                                <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i
                                            class="las la-user-circle tx-16 mr-1"></i></span> <span
                                        class="hidden-xs">{{ __('pages.profile.about') }}</span> </a>
                            </li>
                            @if (Auth::user()->id == $user->id)
                                <li class="">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                                class="las la-cog tx-16 mr-1"></i></span> <span
                                            class="hidden-xs">{{ __('pages.profile.settings') }}</span> </a>
                                </li>
                            @else
                                <li class="">
                                    <a href="#articles" data-toggle="tab" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 15px;"
                                            enable-background="new 0 0 24 24" class="side-menu__icon" viewBox="0 0 24 24">
                                            <g>
                                                <rect fill="none" />
                                            </g>
                                            <g>
                                                <g />
                                                <g>
                                                    <path
                                                        d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M3,18.5V7 c1.1-0.35,2.3-0.5,3.5-0.5c1.34,0,3.13,0.41,4.5,0.99v11.5C9.63,18.41,7.84,18,6.5,18C5.3,18,4.1,18.15,3,18.5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.34,0-3.13,0.41-4.5,0.99V7.49c1.37-0.59,3.16-0.99,4.5-0.99c1.2,0,2.4,0.15,3.5,0.5V18.5z" />
                                                    <path
                                                        d="M11,7.49C9.63,6.91,7.84,6.5,6.5,6.5C5.3,6.5,4.1,6.65,3,7v11.5C4.1,18.15,5.3,18,6.5,18 c1.34,0,3.13,0.41,4.5,0.99V7.49z"
                                                        opacity=".3" />
                                                </g>
                                                <g>
                                                    <path
                                                        d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,10.69,16.18,10.5,17.5,10.5z" />
                                                    <path
                                                        d="M17.5,13.16c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,13.36,16.18,13.16,17.5,13.16z" />
                                                    <path
                                                        d="M17.5,15.83c0.88,0,1.73,0.09,2.5,0.26v-1.52c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,16.02,16.18,15.83,17.5,15.83z" />
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="hidden-xs">{{ __('pages.profile.articles') }}</span> </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                        <div class="tab-pane active" id="home">
                            <h4 class="tx-15 text-uppercase mb-3">{{ __('pages.profile.info') }}</h4>
                            <p class="m-b-5">{{ $user->info }}</p>
                            <div class="m-t-30">
                                <p class="text-muted tx-13 mb-0">{{ __('pages.profile.joinData') }}:
                                    {{ $user->created_at }}</p>
                            </div>
                        </div>
                        @if (Auth::user()->id == $user->id)
                            <div class="tab-pane" id="settings">
                                <form action="{{ route('userUpdate') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="main-img-user profile-user" style="width:100px;height:100px">
                                        <label for="file">
                                            <img alt="" src="{{ asset('files/' . $user->img) }}"
                                                onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"><a
                                                class="fas fa-camera profile-edit"></a>
                                        </label>
                                        <input type="file" name="file" id="file" hidden>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="FullName">{{ __('pages.profile.settings.name') }}</label>
                                        <input type="text" value="{{ old('name', $user->name) }}"
                                            placeholder="{{ __('pages.profile.settings.name') }}" name="name"
                                            id="FullName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Email">{{ __('pages.profile.settings.email') }}</label>
                                        <input type="email" value="{{ $user->email }}"
                                            placeholder="{{ __('pages.profile.settings.email') }}" id="Email"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="Password">{{ __('pages.profile.settings.password') }}</label>
                                        <input type="password"
                                            placeholder="{{ __('pages.profile.settings.password.placeholder') }}"
                                            id="Password" class="form-control" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="AboutMe">{{ __('pages.profile.settings.info') }}</label>
                                        <textarea id="AboutMe" class="form-control" name="info">{{ old('info', $user->info) }}</textarea>
                                    </div>
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">{{ __('pages.profile.settings.save') }}</button>
                                </form>
                            </div>
                        @else
                            <div class="tab-pane" id="articles">
                                <p class="text-center">{{ __('pages.profile.articles.message') }} <a
                                        href="{{ url('articles', $user->id) }}">{{ __('pages.profile.articles.link') }}</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
