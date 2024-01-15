@extends('layouts.master2')
@section('title')
    {{ __('pages.title.email') }}
@endsection
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
@endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets/img/media/forgot.png') }}"
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
                                <div class="mb-5 d-flex">
                                    <h1 class="main-logo1 ml-0 mr-0 my-auto tx-28">lo<span>g</span>Tomey</h1>
                                    <a href="{{ url('/' . ($page = 'home')) }}">
                                        <img src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                                            class="sign-favicon ht-40" alt="logo">
                                    </a>
                                </div>
                                <div class="main-card-signin d-md-flex bg-white">
                                    <div class="wd-100p">
                                        <div class="main-signin-header">
                                            <h2>{{ __('pages.email.title') }}</h2>
                                            <h4>{{ __('pages.email.head') }}</h4>
                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>{{ __('pages.email.input') }}</label> <input
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}" required
                                                        autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-main-primary btn-block"
                                                    type="submit">{{ __('pages.email.btn') }}</button>
                                            </form>
                                        </div>
                                        <div class="main-signup-footer mg-t-20">
                                            <p>{{ __('pages.email.close') }}<a href="{{ route('login') }}">
                                                    {{ __('pages.email.close.link') }}</a>
                                                {{ __('pages.email.close.text') }}
                                            </p>
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
