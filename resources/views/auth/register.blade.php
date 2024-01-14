@extends('layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.register') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets/img/media/register.png') }}"
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
                                    <div class="main-signup-header">
                                        <h2 class="text-primary">{{ __('pages.register.head.title') }}</h2>
                                        <h5 class="font-weight-normal mb-4">{{ __('pages.register.head.message') }}</h5>
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label>{{ __('pages.register.input.name') }}</label> <input
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autofocus
                                                    placeholder="{{ __('pages.register.input.name.placeholder') }}"
                                                    type="text">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('pages.register.input.type') }}</label>
                                                <select name="type" class="form-control select2-no-search">
                                                    <option value="male">
                                                        {{ __('pages.register.input.type.male') }}
                                                    </option>
                                                    <option value="female">
                                                        {{ __('pages.register.input.type.female') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('pages.register.input.email') }}</label> <input
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required
                                                    placeholder="{{ __('pages.register.input.email.placeholder') }}"
                                                    type="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('pages.register.input.password') }}</label> <input
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" value="{{ old('password') }}" required
                                                    placeholder="{{ __('pages.register.input.password.placeholder') }}"
                                                    type="password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <button class="btn btn-main-primary btn-block"
                                                type="submit">{{ __('pages.register.create') }}</button>
                                        </form>
                                        <div class="main-signup-footer mt-2">
                                            <p>{{ __('pages.register.login') }}<a
                                                    href="{{ url('/' . ($page = 'login')) }}">{{ __('pages.register.login.button') }}</a>
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
