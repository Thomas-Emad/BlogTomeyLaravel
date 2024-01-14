@extends('layouts.master')
@section('css')
    <style>
        .bookmark {
            padding: 10px;
            border-radius: 100px;
            transition: 0.3s;
            display: inline-block;
            color: inherit;
        }

        .bookmark:hover {
            background-color: #eee;
        }
    </style>
@endsection
@section('title')
    {{ __('pages.title.favorite') }}
@endsection
@section('page-header')
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <h2 class="card col-12 mt-4 p-3 text-left">{{ __('pages.favorite.title') }}</h2>
        @foreach ($articles as $article)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <img class="card-img-top w-100 w-100" src="{{ url('bgArticles/' . $article->bgArticle) }}" alt="">
                    <div class="card-body">
                        <div style="display: flex; justify-content:space-between">
                            <a href="{{ route('read', [$article->id_user, $article->id]) }}">
                                <h4 class="card-title">{{ $article->title }}</h4>
                            </a>
                            <a href="{{ route('unMark', [Auth::user()->id, $article->id]) }}" class="bookmark"
                                title="Remove From Favorite">
                                <i class="far fa-bookmark"></i>
                            </a>
                        </div>
                        <p class="card-text mb-0">{{ $article->title }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        @if (sizeof($articles) == 0)
            <div class="col-12">
                <div class="card custom-card" style="display:flex; align-items:center; justify-content:space-between;">
                    <strong class="m-0 p-2" style="font-style: italic">{{ __('pages.favorite.message') }}</strong>
                </div>
            </div>
        @endif
    </div>
    <div class="row card align-content-end">
        <ul class="pagination pagination-success m-2">
            @if ($pages_link->currentPage() > 1)
                <li class="page-item"><a class="page-link" href="?page={{ $pages_link->currentPage() - 1 }}"><i
                            class="icon ion-ios-arrow-forward"></i></a>
                </li>
            @endif
            @for ($i = $pages_link->currentPage() - 1; $i < $pages_link->lastPage() + 1; $i++)
                @if ($i > 0)
                    <li class="page-item @if ($i == $pages_link->currentPage()) active @endif"><a class="page-link"
                            href="?page={{ $i }}">{{ $i }}</a></li>
                @endif
            @endfor
            @if ($pages_link->currentPage() < $pages_link->lastPage())
                <li class="page-item"><a class="page-link"
                        href="{{ $pages_link->path() . '?page=' . $pages_link->currentPage() + 1 }}"><i
                            class="icon ion-ios-arrow-back"></i></a></li>
            @endif
        </ul>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
