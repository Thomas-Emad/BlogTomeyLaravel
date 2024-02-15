@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/morris.js/morris.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.owner.statistics') }}
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
                            <div class="">{{ __('pages.owner.statistic.users') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $human_readable->format($countUsers) }}</b>
                            </div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="fe fe-users project bg-pink-transparent text-pink "></i>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="mb-1">{{ __('pages.owner.statistic.users.message') }}</p>
                        <div class="progress progress-sm h-1 mb-1">
                            <div class="progress-bar bg-danger " style='width:{{ $usersDeg }}%' role="progressbar">
                            </div>
                        </div>
                        <small class="mb-0 text-muted">{{ __('pages.owner.statistic.date') }}<span
                                class="float-left text-muted">{{ $usersDeg }}%</span></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="">{{ __('pages.owner.statistic.reactions') }}</div>
                            <div class="h3 mt-2 mb-2">
                                <b>{{ $human_readable->format($totelReaction) }}</b>
                            </div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="project bg-warning-transparent fas fa-thumbs-up plan-icon text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="mb-1">{{ __('pages.owner.statistic.reactions.message') }}</p>
                        <div class="progress progress-sm h-1 mb-1">
                            <div class="progress-bar bg-primary" style="width: {{ $reactionDeg }}%" role="progressbar">
                            </div>
                        </div>
                        <small class="mb-0 text-muted">{{ __('pages.owner.statistic.date') }} <span
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
                            <div class="">{{ __('pages.owner.statistic.views') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $human_readable->format($watchedArticles) }}</b></div>
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
                            <div class="">{{ __('pages.owner.statistic.reports') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $human_readable->format($reports) }}</b></div>
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
                            <div class="">{{ __('pages.owner.statistic.articles') }}</div>
                            <div class="h3 mt-2 mb-2"><b>{{ $human_readable->format($articlesTotle) }}</b></div>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="ti-bar-chart-alt project bg-success-transparent text-success "></i>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="mb-1">{{ __('pages.owner.statistic.articles.message') }}</p>
                        <div class="progress progress-sm h-1 mb-1">
                            <div class="progress-bar bg-success " style="width:{{ $articlesDeg }}%" role="progressbar">
                            </div>
                        </div>
                        <small class="mb-0 text-muted">{{ __('pages.owner.statistic.date') }}<span
                                class="float-right text-muted">{{ $articlesDeg }}%</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-10">{{ __('pages.owner.statistic.topArticles') }}</h4>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-0">{{ __('pages.owner.statistic.topArticles.head') }}</p>
                </div>
                <div class="card-body">
                    <ul class="sales-session mb-0">
                        <?php
                        $i = 1;
                        ?>
                        @foreach (App\Models\Article::orderByDesc('watched')->limit(10)->get() as $article)
                            <li>
                                <div class="d-flex justify-content-between">
                                    <a style="color: inherit"
                                        href="{{ route('read', ['user' => $article->user, 'id' => $article->id]) }}"
                                        target="_blank" rel="noopener noreferrer">
                                        <h6>{{ $i . '. ' . \Str::limit($article->title, 15) }}</h6>
                                    </a>
                                    <p class="font-weight-semibold mb-2">{{ $human_readable->format($article->watched) }}
                                        <span
                                            class="text-muted font-weight-normal">({{ $watchedArticles == 0 ? 0 : round(($article->watched / $watchedArticles) * 100) }}%)</span>
                                    </p>
                                </div>
                                <div class="progress  ht-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                        aria-valuenow="{{ $watchedArticles == 0 ? 0 : round(($article->watched / $watchedArticles) * 100) }}"
                                        class="progress-bar bg-primary"
                                        style="width: {{ $watchedArticles == 0 ? 0 : round(($article->watched / $watchedArticles) * 100) }}%"
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
                        <h4 class="card-title">{{ __('pages.owner.statistic.topUser') }}</h4>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-0">{{ __('pages.owner.statistic.topUser.head') }}</p>
                </div><!-- card-header -->
                <div class="card-body p-0">
                    <div class="browser-stats">
                        @foreach ($topUsers as $user)
                            <a href="{{ route('profile', ['id' => $user->id]) }}" target="__blank"
                                class="d-flex align-items-center item  border-bottom" style="color:inherit">
                                <div class="d-flex">
                                    <img src="{{ asset('files/' . $user->img) }}"
                                        onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'" alt="img"
                                        class="ht-30 wd-30 ml-2">
                                    <div class="">
                                        <h6 class="">{{ \Str::limit($user->name, 15) }}</h6>
                                        <span class="sub-text">{{ $user->created_at }}</span>
                                    </div>
                                </div>
                                <div class="mr-auto my-auto">
                                    <div class="d-flex">
                                        <span class="my-auto">{{ $human_readable->format($user->articles_count) }}</span>
                                    </div>
                                </div>
                            </a>
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
    <?php
    $statActions = $reactionArticlesYear(now()->subYear(5)->format('Y')); ?>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Morris js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/morris.js/morris.min.js') }}"></script>
@endsection
