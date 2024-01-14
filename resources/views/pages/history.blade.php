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
    {{ __('pages.title.history') }}
@endsection
@section('page-header')
@endsection
@section('content')
    <!-- row -->

    <div class="row">
        <h2 class="card col-12 mt-4 p-3 text-left">{{ __('pages.history.title') }}</h2>
        @foreach ($articles as $article)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <img class="card-img-top w-100 w-100" src="{{ url('bgArticles/' . $article->bgArticle) }}" alt="">
                    <div class="card-body">
                        <div style="display: flex; justify-content:space-between">
                            <a href="{{ route('read', [$article->id_user, $article->id]) }}" dir="ltr">
                                <h4 class="card-title">{{ $article->title }}</h4>
                            </a>
                            <div class="dropdown dropleft">
                                <span aria-expanded="false" aria-haspopup="true" data-toggle="dropdown"
                                    id="dropleftMenuButton" type="button"><i class="icon-options-vertical"></i></span>
                                <div aria-labelledby="dropleftMenuButton" class="dropdown-menu tx-13">
                                    <a class="dropdown-item"
                                        href="{{ route('read', [$article->id_user, $article->id]) }}">{{ __('pages.history.actions.read') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('hidden', [$article->id_user, $article->id]) }}">{{ __('pages.history.actions.hidden') }}</a>
                                    <a class="dropdown-item copy_btn" data-user="{{ $article->id_user }}"
                                        data-id="{{ $article->id }}">{{ __('pages.history.actions.link') }}</a>
                                </div>
                            </div>
                        </div>
                        <p class="card-text mb-0" dir="ltr">{{ $article->title }}</p>
                        <div style="font-size:0.7rem; display: flex; align-items: center; justify-content: space-between;"
                            dir="ltr">
                            <span><i class="icon-eye"></i> {{ $article->watched }}</span>
                            <p class="card-text m-0">{{ $article->pivot->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @if (sizeof($articles) == 0)
            <div class="col-12">
                <div class="card custom-card" style="display:flex; align-items:center; justify-content:space-between;">
                    <strong class="m-0 p-2" style="font-style: italic">{{ __('pages.history.message') }}</strong>
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
    <script>
        // Copy Link Article
        $(".copy_btn").on('click', function() {
            let linkSite = location.origin + '/Read/' + $(".copy_btn").attr('data-user') + '/' + $(".copy_btn")
                .attr(
                    'data-id');
            navigator.clipboard
                .writeText(linkSite)
                .then(() => {
                    console.log("Now You Have a Link..");
                    alert("You have a link now..");
                })
                .catch((error) => {
                    console.error("Failed to copy:", error);
                });
        });
    </script>
@endsection
