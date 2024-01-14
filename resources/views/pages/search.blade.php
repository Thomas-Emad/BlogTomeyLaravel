@extends('layouts.master')
@section('css')
@endsection
@section('title')
    {{ __('pages.title.search') }}
@endsection
@section('content')
    <!-- row -->
    <div class="row mt-4">
        <div class="col-sm-12 col-md-12">
            <form action="{{ route('searchForm') }}" method="get" class="card custom-card">
                @csrf
                <div class="card-body pb-0">
                    <div class="input-group mb-2">
                        <input class="form-control" name="title" type="text" list="datalistOptions"
                            placeholder="{{ __('pages.search.placeholder') }}" value="{{ request()->segment(3) }}">
                        <datalist id="datalistOptions">
                            @foreach ($lastSearched as $item)
                                <option value="{{ $item->content }}"></option>
                            @endforeach
                        </datalist>
                        <span class="input-group-append">
                            <button class="btn ripple btn-primary" type="submit">{{ __('pages.search.button') }}</button>
                        </span>
                    </div>
                </div>
                <div class="card-body pl-0 pr-0 bd-t-0 pt-0">
                    <div class="main-content-body-profile mb-3">
                        <nav class="nav main-nav-line"
                            style='white-space: pre;height: 60px; flex-direction: row; flex-wrap: nowrap; overflow: hidden; overflow-x: scroll; padding: 10px; word-wrap: pre;'>
                            <a href="{{ url('search', ['type' => 'all']) }}"
                                class="nav-link @if (empty(request()->segment(2)) || request()->segment(2) == 'all') active @endif">all</a>
                            @foreach ($types as $type)
                                <a class="nav-link @if (!empty(request()->segment(2)) && request()->segment(2) == $type->name) active @endif"
                                    href="{{ url('search', ['type' => $type->name, 'title' => request()->segment(3)]) }}">{{ $type->name }}</a>
                            @endforeach
                        </nav>
                    </div>
                    <p class="text-muted mb-0 pl-3 pr-3">
                        {{ __('pages.search.timeResult', ['count' => $articles->count(), 'time' => number_format($requestTime, 2)]) }}
                    </p>
                </div>
            </form>
            <div class="row">
                @foreach ($articles as $article)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="card custom-card">
                            <img class="card-img-top w-100 w-100" src="{{ url('bgArticles/' . $article->bgArticle) }}"
                                alt="">
                            <div class="card-body">
                                <a href="{{ route('read', [$article->id_user, $article->id]) }}">
                                    <h4 class="card-title">{{ $article->title }}</h4>
                                </a>
                                <p class="card-text mb-0">{{ \Str::limit(strip_tags($article->content, ENT_COMPAT), 40) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if (sizeof($articles) == 0)
                    <div class="col-12">
                        <div class="card custom-card"
                            style="display:flex; align-items:center; justify-content:space-between;">
                            <strong class="m-0 p-2" style="font-style: italic">{{ __('pages.search.message') }}</strong>
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center search float-left">
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
        </div>
    </div>
    <!-- row closed -->
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
    <!-- Internal Rating js-->
    <script src="{{ URL::asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/rating/jquery.barrating.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/rating/ratings.js') }}"></script>
@endsection
