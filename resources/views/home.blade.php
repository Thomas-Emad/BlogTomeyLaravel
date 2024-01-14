@extends('layouts.master')
@section('css')
    <style>
        .img_author {
            transition: 0.5s
        }

        .img_author:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
@section('title')
    {{ __('pages.title.home') }}
@endsection
@section('page-header')
    <!-- Author -->
    @if (sizeof($youFollow) > 0)
        <div class="breadcrumb-header justify-content-between card p-3">
            <div class="row"
                style='flex-direction: row; gap:10px; flex-wrap: nowrap; overflow: hidden; overflow-x: scroll; padding: 0 10px;'>
                @foreach ($youFollow as $author)
                    <a href="{{ url('articles', $author->id) }}" title='Open Profile {{ $author->name }}'>
                        @if (!empty($author->img))
                            <img src="{{ url('files/' . $author->img) }}" class="img_author"
                                onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"
                                style="width:50px;height:50px;border-radius:100px">
                        @else
                            <div class="avatar bg-info rounded-circle img_author" style="width:50px;height:50px">
                                {{ $author->name[0] }}
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    <!-- End Author -->
    <!-- Types -->
    <div class="breadcrumb-header justify-content-between card p-3">
        <div class="row"
            style='white-space: pre;height: 60px; flex-direction: row; flex-wrap: nowrap; overflow: hidden; overflow-x: scroll; padding: 10px; word-wrap: pre;'>
            @foreach ($types as $type)
                <a href="{{ url('home', $type->name) }}"
                    class="btn btn-outline-secondary btn-rounded ml-1 mr-1  @if (
                        (!empty(request()->segment(2)) && request()->segment(2) == $type->name) ||
                            (empty(request()->segment(2)) && $loop->first)) active @endif">{{ $type->name }}</a>
            @endforeach
        </div>
    </div>
    <!-- End Types -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        @foreach ($articles as $article)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <img class="card-img-top w-100" style="height: 120px;"
                        src="{{ url('bgArticles/' . $article->bgArticle) }}" alt="">
                    <div class="card-body">
                        <a href="{{ route('read', [$article->id_user, $article->id]) }}">
                            <h4 class="card-title">{{ \Str::limit(strip_tags($article->title, ENT_COMPAT), 20) }}</h4>
                        </a>
                        <p class="card-text mb-0">{{ \Str::limit(strip_tags($article->content, ENT_COMPAT), 40) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        @if (sizeof($recommendArticles) > 0)
            @foreach ($recommendArticles as $article)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card custom-card">
                        <img class="card-img-top w-100" style="height: 120px;"
                            src="{{ url('bgArticles/' . $article->bgArticle) }}" alt="">
                        <div class="card-body">
                            <a href="{{ route('read', [$article->id_user, $article->id]) }}">
                                <h4 class="card-title">{{ \Str::limit(strip_tags($article->title, ENT_COMPAT), 20) }}</h4>
                            </a>
                            <p class="card-text mb-0">{{ \Str::limit(strip_tags($article->content, ENT_COMPAT), 40) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if (sizeof($articles) == 0 && sizeof($recommendArticles) == 0)
            <div class="col-12">
                <div class="card custom-card" style="display:flex; align-items:center; justify-content:space-between;">
                    <strong class="m-0 p-2" style="font-style: italic">{{ __('pages.index.message') }}</strong>
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
