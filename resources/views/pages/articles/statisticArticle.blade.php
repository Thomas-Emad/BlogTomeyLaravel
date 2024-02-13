@extends('layouts.master')
@section('css')
    <!-- Internal Morris Css-->
    <link href="{{ URL::asset('assets/plugins/morris.js/morris.css') }}" rel="stylesheet">
    <style>
        @media (max-width:767px) {
            .head {
                flex-direction: column-reverse;
            }
        }
    </style>
@endsection
@section('title')
    {{ __('pages.title.statisticArticle') }} | {{ $article->title }}
@endsection
@section('page-header')
@endsection
@section('content')
    <!-- row -->
    @if ($article->hidden != null)
        <div class="alert alert-danger w-100 mt-4 text-center">
            {{ __('pages.statisticArticle.blockArticle') }}
            <br>
            <span>{{ $article->hidden }}</span>
        </div>
    @endif
    <div class="row mt-4">
        <div class="col-12 card pt-2 d-flex" style='gap:10px;'>
            <div class="head d-flex justify-content-between" style='gap:15px;'>
                <div class="text w-100">
                    <div class="w-100 bd rounded-5 p-2 bg-gray-100 mb-1">{{ $article->title }}</div>
                    <div class="w-100 bd rounded-5 p-2 bg-gray-100">
                        @foreach ($article->types as $type)
                            <span class="bd"
                                style="background: #fff;padding:5px;border-radius:5px;margin:2px;">{{ $type->name }}</span>
                        @endforeach
                    </div>
                    @can('articles-controll')
                        @if ($article->hidden == null)
                            <div class="actions row mt-1" style="gap: 10px">
                                <a href="{{ route('read', [$article->id_user, $article->id]) }}"
                                    class="btn btn-outline-primary col-12">{{ __('pages.statisticArticle.btn.view') }}</a>
                                <a href="{{ route('editArticle', [$article->id_user, $article->id]) }}"
                                    class="btn btn-outline-success col-12">{{ __('pages.statisticArticle.btn.edit') }}</a>
                                <a class="btn btn-outline-danger modal-effect btnDel col-12" data-title="{{ $article->title }}"
                                    data-id="{{ $article->id }}" data-effect="effect-scale" data-toggle="modal"
                                    href="#modaldemo8">{{ __('pages.statisticArticle.btn.delete') }}</a>
                            </div>
                        @endif
                    @endcan
                </div>
                <div class="img" style="background-color: bisque; width:200px;height:200px">
                    <img src="{{ asset('bgArticles/' . $article->bgArticle) }}" class="rounded-5"
                        style="width: 100%; height:100%">
                </div>
            </div>
            <hr>
            <ul class="nav" style="gap:10px; justify-content: center;">
                <li><a href="#information" class="btn btn-outline-primary"><i class="fa fa-laptop"></i>
                        {{ __('pages.statisticArticle.info') }}</a></li>
                <li><a href="#comments" class="btn btn-outline-primary"><i class="fa fa-cube"></i>
                        {{ __('pages.statisticArticle.comments') }}</a></li>
                <li><a href="#static" class="btn btn-outline-primary"><i class="fa fa-cogs"></i>
                        {{ __('pages.statisticArticle.statistic') }}</a></li>
            </ul>
            <hr>
        </div>
    </div>
    <div class="content " id="content">
        <div class="information mb-3 card p-3" id="information">
            <h4>{{ __('pages.statisticArticle.info.title') }}</h4>
            <div class="p-2 rounded-5 bg-gray-100 bd text-left">
                {!! \Str::limit($article->content, 500) !!}
            </div>
            <div class="p-2 rounded-5 bg-gray-100 bd mt-2 text-left">
                <span><b>{{ __('pages.statisticArticle.info.created') }}:</b>{{ $article->created_at }}</span><br>
                <span><b>{{ __('pages.statisticArticle.info.edit') }}:</b>{{ $article->updated_at }}</span>
            </div>
        </div>

    </div>

    <div class="comments mb-3" id="comments">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">{{ __('pages.statisticArticle.comments.title') }}</h4>
                    <i class="mdi mdi-dots-vertical"></i>
                </div>
                <p class="card-description mb-1">{{ __('pages.statisticArticle.comments.head') }}</p>
                @foreach ($article->comments()->orderByDesc('created_at')->limit(10)->get() as $comment)
                    <div class="list d-flex align-items-center border-bottom py-3">
                        <a target="__blank">
                            <img class="avatar brround d-block cover-image" src="{{ url('files/' . $comment->user->img) }}"
                                onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'">
                        </a>
                        <div class="wrapper w-100 mr-3">
                            <p class="mb-0">
                                <b>{{ $comment->user->name }}</b>
                            </p>
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">{{ \Str::limit($comment->comment, 20) }}</p>
                                </div>
                                <small class="text-muted mr-auto">
                                    <i class="mdi mdi-clock text-muted ml-1"></i>
                                    {{ $comment->created_at }} </small>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if (sizeof($article->comments()->orderByDesc('created_at')->limit(10)->get()) == 0)
                    <p class="text-center text-lite btn bg-gray-100  w-100" style="font-weight:bold">
                        {{ __('pages.statisticArticle.comments.message') }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row row-sm mb-3" id="static">
        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card bg-success-gradient text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-bar-chart-2 tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">{{ __('pages.statisticArticle.statistic.views') }}</span>
                                <h2 class="text-white mb-0">
                                    {{ $human_readable->format($article->watched) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card bg-primary-gradient text-white ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-thumbs-up tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">{{ __('pages.statisticArticle.statistic.likes') }}</span>
                                <h2 class="text-white mb-0">
                                    {{ $human_readable->format($likes) }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card bg-pink-gradient text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-message-circle tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">{{ __('pages.statisticArticle.statistic.comments') }}</span>
                                <h2 class="text-white mb-0">
                                    {{ $human_readable->format($article->comments->count()) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card bg-warning-gradient text-white ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-thumbs-down tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">{{ __('pages.statisticArticle.statistic.disLikes') }}</span>
                                <h2 class="text-white mb-0">
                                    {{ $human_readable->format($disLikes) }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card bg-danger-gradient text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-flag tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">{{ __('pages.statisticArticle.statistic.reports') }}</span>
                                <h2 class="text-white mb-0">{{ $article->reports->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ __('pages.statisticArticle.statistic.chart.view') }}
                    </div>
                    <p class="mg-b-20">{{ __('pages.statisticArticle.statistic.chart.view.head') }}</p>
                    <div class="morris-wrapper-demo" id="morrisArea1"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mg-b-md-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ __('pages.statisticArticle.statistic.chart.type') }}
                    </div>
                    <p class="mg-b-20">{{ __('pages.statisticArticle.statistic.chart.type.head') }}</p>
                    <div class="morris-donut-wrapper-demo" id="morrisDonut1"></div>
                </div>
            </div>
        </div><!-- col-6 -->
    </div>
    <!-- Modal effects -->
    <div class="modal" id="modaldemo8" dir="ltr" style="text-align: left">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('pages.statisticArticle.modal.delete') }}</h6><button
                        aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h6>{{ __('pages.statisticArticle.modal.delete.ask') }}</h6>
                    <p>{{ __('pages.statisticArticle.modal.delete.title') }}: <span id="titleArticleDel"></span></p>
                </div>
                <form method="POST" action='{{ route('delArticle') }}' class="modal-footer">
                    @csrf
                    <input type="hidden" name="id" id="idInputDel">
                    <button class="btn ripple btn-outline-danger"
                        type="submit">{{ __('pages.statisticArticle.modal.delete.delete') }}</button>
                    <button class="btn ripple btn-outline-success" data-dismiss="modal"
                        type="button">{{ __('pages.statisticArticle.modal.delete.close') }}</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    </div>
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
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        // Info Model Delete Article
        $('.btnDel').click(function(e) {
            $('#idInputDel').val($(this).data('id'));
            $('#titleArticleDel').text($(this).data('title'));
        });

        new Morris.Donut({
            element: 'morrisDonut1',
            data: [{
                label: '{{ __('pages.statisticArticle.statistic.chart.type.men') }}',
                value: {{ $watchedTypeUser($article, 'male') }}
            }, {
                label: '{{ __('pages.statisticArticle.statistic.chart.type.women') }}',
                value: {{ $watchedTypeUser($article, 'female') }}
            }],
            colors: ['#6d6ef3', '#f7557a'],
            resize: true,
            labelColor: "#8c9fc3"
        });

        // Static View Article
        new Morris.Area({
            element: 'morrisArea1',
            data: [
                @foreach ($watchedStaticMonthForYear($article, now()->format('Y')) as $date => $value)
                    {
                        y: "{{ $date }}",
                        a: "{{ $value }}",
                    },
                @endforeach
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['{{ __('pages.statisticArticle.statistic.chart.view') }}'],
            lineColors: ['#f7557a'],
            lineWidth: 1,
            fillOpacity: 0.9,
            gridTextSize: 11,
            hideHover: 'auto',
            resize: true
        });
    </script>
    <script>
        // Info Model Delete Article
        $('.btnDel').click(function(e) {
            $('#idInputDel').val($(this).data('id'));
            $('#titleArticleDel').text($(this).data('title'));
        });
    </script>
@endsection
