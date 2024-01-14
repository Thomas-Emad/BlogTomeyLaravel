@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/morris.js/morris.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.statistic') }}
@endsection
@section('page-header')
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm mt-4">
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="">{{ __('pages.statistic.followers') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $allFollowers }}</b>
                            </div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="fe fe-users project bg-pink-transparent text-pink "></i>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="mb-1">{{ __('pages.statistic.followers.message') }}</p>
                        <div class="progress progress-sm h-1 mb-1">
                            <div class="progress-bar bg-danger " style='width:{{ $followersDeg }}%' role="progressbar">
                            </div>
                        </div>
                        <small class="mb-0 text-muted">{{ __('pages.statistic.date') }}<span
                                class="float-left text-muted">{{ $followersDeg }}%</span></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="">{{ __('pages.statistic.reactions') }}</div>
                            <div class="h3 mt-2 mb-2">
                                <b>{{ $totelReaction }}</b>
                            </div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="project bg-warning-transparent fas fa-thumbs-up plan-icon text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="mb-1">{{ __('pages.statistic.reactions.message') }}</p>
                        <div class="progress progress-sm h-1 mb-1">
                            <div class="progress-bar bg-primary" style="width: {{ $reactionDeg }}%" role="progressbar">
                            </div>
                        </div>
                        <small class="mb-0 text-muted">{{ __('pages.statistic.date') }} <span
                                class="float-left text-muted">{{ $reactionDeg }}%</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="">{{ __('pages.statistic.views') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $watchedArticles }}</b></div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="fe fe-eye project bg-primary-transparent text-primary "></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="">{{ __('pages.statistic.reports') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $user->articles()->whereHas('reports')->count() }}</b></div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="ti-pulse project bg-warning-transparent text-warning "></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="">{{ __('pages.statistic.articles') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $articlesTotle }}</b></div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="ti-bar-chart-alt project bg-success-transparent text-success "></i>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="mb-1">{{ __('pages.statistic.articles.message') }}</p>
                        <div class="progress progress-sm h-1 mb-1">
                            <div class="progress-bar bg-success " style="width:{{ $articlesDeg }}%" role="progressbar">
                            </div>
                        </div>
                        <small class="mb-0 text-muted">{{ __('pages.statistic.date') }}<span
                                class="float-right text-muted">{{ $articlesDeg }}%</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">{{ __('pages.statistic.comments') }}</h4>
                        <i class="mdi mdi-dots-vertical"></i>
                    </div>
                    <p class="card-description mb-1">{{ __('pages.statistic.comments.head') }}</p>
                    @if (sizeof($user->articles->comments->take(10)) == 0)
                        <p style="text-align: center; font-weight: bold; font-style: italic;">
                            {{ __('pages.statistic.comments.no') }}
                        </p>
                    @endif
                    @foreach ($user->articles->comments->take(10) as $comment)
                        <div class="list d-flex align-items-center border-bottom py-3">
                            <a target="__blank"
                                href="{{ route('read', ['user' => $comment->article->id_user, 'id' => $comment->article->id]) }}">
                                <img class="avatar brround d-block cover-image" src='{{ $comment->article->bgArticle }}'>
                            </a>
                            <div class="wrapper w-100 mr-3">
                                <p class="mb-0">
                                    <b>{{ $comment->user->name }} </b>{{ $comment->article->title }}
                                </p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted ml-1"></i>
                                        <p class="mb-0">{{ \Str::limit($comment->comment, 15) }}</p>
                                    </div>
                                    <small class="text-muted mr-auto">
                                        {{ now()->diffInHours($comment->created_at) }}
                                        {{ __('pages.statistic.comments.date') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ __('pages.statistic.staticReaction') }}
                    </div>
                    <p class="mg-b-20">{{ __('pages.statistic.staticReaction.head') }}</p>
                    <div class="morris-wrapper-demo" id="morrisArea1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-10">{{ __('pages.statistic.topArticles') }}</h4>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-0">{{ __('pages.statistic.topArticles.head') }}</p>
                </div>
                <div class="card-body">
                    <ul class="sales-session mb-0">
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($user->articles()->orderByDesc('watched')->limit(10)->get() as $article)
                            <li>
                                <div class="d-flex justify-content-between">
                                    <a style="color: inherit"
                                        href="{{ route('read', ['user' => $article->user, 'id' => $article->id]) }}"
                                        target="_blank" rel="noopener noreferrer">
                                        <h6>{{ $i . '. ' . \Str::limit($article->title, 15) }}</h6>
                                    </a>
                                    <p class="font-weight-semibold mb-2">{{ $article->watched }} <span
                                            class="text-muted font-weight-normal">({{ round(($article->watched / $user->articles->sum('watched')) * 100) }}%)</span>
                                    </p>
                                </div>
                                <div class="progress  ht-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                        aria-valuenow="{{ round(($article->watched / $user->articles->sum('watched')) * 100) }}"
                                        class="progress-bar bg-primary"
                                        style="width: {{ round(($article->watched / $user->articles->sum('watched')) * 100) }}%"
                                        role="progressbar"></div>
                                </div>
                            </li>
                            <?php $i++; ?>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">{{ __('pages.statistic.newArticles') }}</h4>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-0">{{ __('pages.statistic.newArticles.head') }}</p>
                </div><!-- card-header -->
                <div class="card-body p-0">
                    <div class="browser-stats">
                        @foreach ($user->articles->orderByDesc('created_at')->limit(10)->get() as $article)
                            <div class="d-flex align-items-center item  border-bottom">
                                <div class="d-flex">
                                    <img src="{{ url('bgArticles/' . $article->bgArticle) }}" alt="img"
                                        class="ht-30 wd-30 ml-2">
                                    <div class="">
                                        <h6 class="">{{ \Str::limit($article->title, 15) }}</h6>
                                        <span class="sub-text">{{ $article->created_at }}</span>
                                    </div>
                                </div>
                                <div class="mr-auto my-auto">
                                    <div class="d-flex">
                                        <span class="my-auto">{{ $article->watched }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><!-- card -->
        </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Morris js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris.js/morris.min.js') }}"></script>
    <!--Internal Chart Morris js -->
    <script src="{{ URL::asset('assets/js/chart.morris.js') }}"></script>
    <script>
        let morrisArea1 = document.getElementById('morrisArea1');
        new Morris.Area({
            element: 'morrisArea1',
            data: [
                @foreach ($reactionArticlesYear(
        now()->subYear(5)->format('Y'),
        $user,
        '1',
    ) as $key => $value)
                    {
                        y: {{ $key }} + '-01-01',
                        a: {{ $value[0] }},
                        b: {{ $value[1] }}
                    },
                @endforeach
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Like', 'DisLike'],
            lineColors: ['#6d6ef3', '#f7557a'],
            lineWidth: 1,
            fillOpacity: 0.9,
            gridTextSize: 11,
            hideHover: 'auto',
            resize: true
        });
    </script>
@endsection
