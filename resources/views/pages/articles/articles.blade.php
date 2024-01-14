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

        .boxCard {
            display: flex;
            gap: 5px;
            align-items: center;
        }
    </style>
@section('title')
    {{ __('pages.articles.head') }}
@endsection
@section('content')
    <!-- row -->
    @if (\Auth::user()->id != $user->id)
        <div class="row">
            <div class="card col-12 mt-4 p-3 text-left"
                style="display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <div class="boxCard">
                    @if (!empty($user->img))
                        <img src="{{ url('files/' . $user->img) }}" alt=""
                            onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"
                            style="width:50px;height:50px;border-radius:100px">
                    @else
                        <div class="avatar bg-info rounded-circle" style="width:50px;height:50px">
                            {{ $user->name[0] }}
                        </div>
                    @endif
                    <span style='font-weight: bold; font-size: 1.1rem; margin-right: 5px;'>{{ $user->name }}</span>
                </div>
                <div class="boxCard">
                    @if (\Auth::user()->follow->where('id_author', $user->id)->first())
                        <a href="{{ route('follow', ['id' => $user->id]) }}" class="btn btn-outline-primary w-100 mt-2">
                            {{ __('pages.articles.unFollow') }}
                        </a>
                    @else
                        <a href="{{ route('follow', ['id' => $user->id]) }}" class="btn btn-primary w-100 mt-2">
                            {{ __('pages.articles.follow') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <h2 class="card col-12 p-3 text-left @if (\Auth::user()->id == $user->id) mt-4 @endif">
            {{ __('pages.articles.you', ['name' => $user->name]) }}
        </h2>
        @foreach ($articles as $article)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <img class="card-img-top w-100" style="height: 120px;"
                        src="{{ url('bgArticles/' . $article->bgArticle) }}" alt="">
                    <div class="card-body">
                        <div style="display: flex; justify-content:space-between">
                            <a href="{{ route('read', [$article->id_user, $article->id]) }}" dir="ltr">
                                <h4 class="card-title">{{ \Str::limit(strip_tags($article->title, ENT_COMPAT), 20) }}</h4>
                            </a>
                            @if (\Auth::user()->id == $article->id_user)
                                <div class="dropdown dropleft">
                                    <span aria-expanded="false" aria-haspopup="true" data-toggle="dropdown"
                                        id="dropleftMenuButton" type="button"><i class="icon-options-vertical"></i></span>
                                    <div aria-labelledby="dropleftMenuButton" class="dropdown-menu tx-13">
                                        <a class="dropdown-item"
                                            href="{{ route('read', [$article->id_user, $article->id]) }}">{{ __('pages.articles.actions.read') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('statisticArticle', [$article->id_user, $article->id]) }}">{{ __('pages.articles.actions.statistic') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('editArticle', [$article->id_user, $article->id]) }}">{{ __('pages.articles.actions.edit') }}</a>
                                        <a class="dropdown-item copy_btn" data-user="{{ $article->id_user }}"
                                            data-id="{{ $article->id }}">{{ __('pages.articles.actions.link') }}</a>
                                        <a class="dropdown-item modal-effect btnDel" data-title="{{ $article->title }}"
                                            data-id="{{ $article->id }}" data-effect="effect-scale" data-toggle="modal"
                                            href="#modaldemo8">{{ __('pages.articles.actions.delete') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="card-text mb-0" dir="ltr">
                            {{ \Str::limit(strip_tags($article->content, ENT_COMPAT), 20) }}</p>
                        <div style="font-size:0.7rem; display: flex; align-items: center; justify-content: space-between;"
                            dir="ltr">
                            <span><i class="icon-eye"></i> {{ $article->watched }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @if (sizeof($articles) == 0)
            <div class="col-12">
                <div class="card custom-card" style="display:flex; align-items:center; justify-content:space-between;">
                    <strong class="m-0 p-2" style="font-style: italic">{{ __('pages.articles.message') }}</strong>
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
    <!-- Modal effects -->
    <div class="modal" id="modaldemo8" dir="ltr" style="text-align: left">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('pages.articles.modal.delete') }}</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h6>{{ __('pages.articles.modal.delete.message') }}</h6>
                    <p>{{ __('pages.articles.modal.delete.name') }} <span id="titleArticleDel"></span></p>
                </div>
                <form method="POST" action='{{ route('delArticle') }}' class="modal-footer">
                    @csrf
                    <input type="hidden" name="id" id="idInputDel">
                    <button class="btn ripple btn-outline-danger"
                        type="submit">{{ __('pages.articles.modal.delete.delete') }}</button>
                    <button class="btn ripple btn-outline-success" data-dismiss="modal"
                        type="button">{{ __('pages.articles.modal.delete.close') }}</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
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

        // Info Model Delete Article
        $('.btnDel').click(function(e) {
            $('#idInputDel').val($(this).data('id'));
            $('#titleArticleDel').text($(this).data('title'));
        });
    </script>
@endsection
