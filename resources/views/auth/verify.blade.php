@extends('layouts.master2')
@section('css')
    <!--- Internal Fontawesome css-->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!---Ionicons css-->
    <link href="{{ URL::asset('assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <!---Internal Typicons css-->
    <link href="{{ URL::asset('assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet">
    <!---Internal Feather css-->
    <link href="{{ URL::asset('assets/plugins/feather/feather.css') }}" rel="stylesheet">
    <!---Internal Falg-icons css-->
    <link href="{{ URL::asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.verify') }}
@endsection
@section('content')
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('pages.verify.session') }}
        </div>
    @endif
    <!-- Main-error-wrapper -->
    <div class="main-error-wrapper  page page-h ">
        <img src="{{ URL::asset('assets/img/media/verify.png') }}" class="error-page" alt="error">
        <h2>{{ __('pages.verify.head') }}</h2>
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-outline-success">{{ __('pages.verify.send') }}</button>.
        </form>
    </div>
    <!-- /Main-error-wrapper -->
@endsection
@section('js')
@endsection
