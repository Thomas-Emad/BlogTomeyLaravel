@extends('layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.login') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets/img/media/login.png') }}"
                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex">
                                        <h1 class="main-logo1 ml-0 mr-0 my-auto tx-28">lo<span>g</span>Tomey</h1>
                                        <a href="{{ url('/' . ($page = 'home')) }}">
                                            <img src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                                                class="sign-favicon ht-40" alt="logo">
                                        </a>
                                    </div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>{{ __('pages.login.head.title') }}</h2>
                                            <h5 class="font-weight-semibold mb-4">{{ __('pages.login.head.message') }}</h5>
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>{{ __('pages.login.input.email') }}</label>
                                                    <input class="form-control @error('email') is-invalid @enderror"
                                                        name="email"
                                                        placeholder="{{ __('pages.login.input.email.placeholder') }}"
                                                        value="{{ old('email') }}" type="email" required>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('pages.login.input.password') }}</label> <input
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="{{ __('pages.login.input.password.placeholder') }}"
                                                        type="password" name="password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-main-primary btn-block"
                                                    type="submit">{{ __('pages.login.login') }}</button>
                                            </form>
                                            <div class="main-signin-footer mt-5">
                                                <p><a href="{{ route('password.request') }}">{{ __('pages.login.forgot') }}
                                                    </a>
                                                </p>
                                                <p>{{ __('pages.login.register') }} <a
                                                        href="{{ url('/' . ($page = 'register')) }}">{{ __('pages.login.register.button') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
@endsection
@section('js')
@endsection
