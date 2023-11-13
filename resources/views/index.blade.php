@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between card p-3">
        <div class="row wd-xl-20p"
            style='height: 60px; flex-direction: row; flex-wrap: nowrap; overflow: hidden; overflow-x: scroll; padding: 10px;'>
            @foreach ($types as $type)
                <a href="{{ $type->id }}"
                    class="btn btn-outline-secondary btn-rounded ml-1 mr-1  @if ($loop->first) active @endif">{{ $type->name }}</a>
            @endforeach
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        @foreach ($articles as $article)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <img class="card-img-top w-100 w-100" src="{{ $article->bgArticle }}" alt="">
                    <div class="card-body">
                        <a href="{{ route('read', [$article->id_user, $article->id]) }}">
                            <h4 class="card-title">{{ $article->title }}</h4>
                        </a>
                        <p class="card-text mb-0">{{ $article->title }}</p>
                    </div>
                </div>
            </div>
        @endforeach
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
