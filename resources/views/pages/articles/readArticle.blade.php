@extends('layouts.master')
@section('css')
    <style>
        .card_art {
            transition: 0.3s;
            cursor: pointer;
        }

        .card_art:hover {
            transform: translateY(-5px)
        }
    </style>
@section('title')
    {{ $article->title }}
@endsection
@endsection
@section('page-header')
@endsection
@section('content')
<!-- row -->
<div class="row mt-3 text-left" dir="ltr">
    <div class="card col-12 p-3 mb-2">
        <div class="title" style="display:flex;justify-content:space-between;">
            <h1>{{ $article->title }}</h1>
            <div style="display:flex;flex-direction:column;">
                <strong>{{ __('pages.readArticle.author') }} {{ $article->user->name }}</strong>
                <strong style="display:block; text-align:right">
                    <i class="icon-eye"></i> {{ $article->watched }}
                </strong>
            </div>
        </div>
        <div><img alt="Responsive image" class="img-fluid"
                src="{{ isset($article->bgArticle) ? url('bgArticles/' . $article->bgArticle) : 'http://127.0.0.1:8000/assets/img/photos/1.jpg' }}"
                style="margin: 0 auto;width: 100%; height:400px">
        </div>
        <div class="content mt-3 mb-3">
            {!! $article->content !!}
        </div>
        <div class="links text-right" style="display:flex;justify-content:space-between;">
            @auth
                <div style="display: flex; gap: 5px; align-items: center;">
                    <a title="{{ __('pages.readArticle.btn.like') }}"
                        href="{{ route('reaction', [$article->id_user, $article->id, '1']) }}"
                        style="display: flex; align-items: center;"
                        class="btn btn-outline-light @if ($article->ReactionArticles->where('id_user', Auth::user()->id)->where('action', 1)->count() > 0) active @endif"><ion-icon
                            name="heart"></ion-icon>{{ $article->ReactionArticles->where('action', '=', 1)->count() }}</a>
                    <a title="{{ __('pages.readArticle.btn.disLike') }}"
                        href="{{ route('reaction', [$article->id_user, $article->id, '0']) }}"
                        style="display: flex; align-items: center;"
                        class="btn btn-outline-light
                            @if ($article->ReactionArticles->where('id_user', Auth::user()->id)->where('action', 0)->count() > 0) active @endif"><ion-icon
                            name="heart-dislike"></ion-icon>{{ $article->ReactionArticles->where('action', '=', 0)->count() }}</a>
                </div>
            @endauth
            <div>
                <a class="btn btn-info copy_btn" data-container="body" data-toggle="popover"
                    data-popover-color="default" data-placement="top"
                    title="{{ __('pages.readArticle.btn.link.title') }}"
                    data-content="{{ __('pages.readArticle.btn.link.content') }}"
                    data-original-title="Popover top">{{ __('pages.readArticle.btn.link') }}</a>
                @auth
                    @if (isset($article->MarkArticles) && !empty($article->MarkArticles->where('id_user', Auth::user()->id)))
                        <a href="{{ route('unMark', [$article->id_user, $article->id]) }}"
                            class="btn btn-warning">{{ __('pages.readArticle.btn.unSave') }}</a>
                    @else
                        <a href="{{ route('markUp', [$article->id_user, $article->id]) }}"
                            class="btn btn-success">{{ __('pages.readArticle.btn.save') }}</a>
                    @endif
                    @if ($article->reports->where('id_user_report', Auth::user()->id)->first())
                        <button type="button" class="btn btn-danger"
                            disabled>{{ __('pages.readArticle.btn.report') }}</button>
                    @else
                        <a href="{{ route('report', [$article->id_user, $article->id]) }}"
                            class="btn btn-outline-danger">{{ __('pages.readArticle.btn.report') }}</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
<div class="row text-left" dir="ltr">
    <div class="card col-12 p-3 text-left mb-0">
        <h3>{{ __('pages.readArticle.author') }}</h3>
        <div class="info" style="display:flex;gap:20px">
            <a href="{{ route('profile', ['id' => $article->user->id]) }}">
                @if (!empty($article->user->img))
                    <img src="{{ url('files/' . $article->user->img) }}" alt=""
                        onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"
                        style="width:50px;height:50px;border-radius:100px">
                @else
                    <div class="avatar bg-info rounded-circle" style="width:50px;height:50px">
                        {{ $article->user->name[0] }}
                    </div>
                @endif
            </a>
            <div class="content" style="max-width: 75%">
                <a href="{{ route('profile', ['id' => $article->user->id]) }}">
                    <h3 class="text-info mb-0">{{ $article->user->name }}</h3>
                </a>
                <div class="descrption">
                    {{ $article->user->info }}
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
@if ($article->comment == 'allow')
    <div class="row comments">
        <div class="card col-12 p-3 text-left mb-2">
            <h3 class="m-0">{{ __('pages.readArticle.comment') }}</h3>
            @auth
                <form method="POST" action="{{ url('/Read/' . $article->id_user . '/' . $article->id . '/Comment') }}"
                    style="display: flex; flex-direction: row-reverse; align-items: center; gap: 10px;">
                    @csrf
                    <textarea class="form-control text-left" name="comment"
                        placeholder="{{ __('pages.readArticle.comment.placeholder') }}"></textarea>
                    <button type="submit" class="btn btn-primary">{{ __('pages.readArticle.comment.add') }}</button>
                </form>
            @endauth
            @guest
                <p class="text-center">{{ __('pages.readArticle.comment.login') }}</p>
            @endguest
        </div>
        <div class="col-12 text-left">
            <?php $i = 0; ?>
            @foreach ($article->comments->where('refer', null) as $comment)
                <div class="comment_box" data-num='{{ $i }}'>
                    <div class="card col-12 p-3 mb-2"
                        style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
                        <div style="display: flex; flex-direction: row-reverse; gap: 10px;">
                            @if (!empty($comment->user->img))
                                <img src="{{ $comment->user->img }}" alt=""
                                    title="{{ $comment->user->name }}">
                            @else
                                <div class="avatar bg-info rounded-circle" style="width:50px;height:50px"
                                    title="{{ $comment->user->name }}">
                                    {{ $comment->user->name[0] }}
                                </div>
                            @endif
                            <div style="display: flex;flex-direction: column;">
                                <div
                                    style="gap: 10px; display: flex; align-items: flex-end; flex-direction: row-reverse;">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <div style="font-size: 0.6rem">
                                        <div class="time">A:{{ $comment->created_at }}</div>
                                        @if ($comment->created_at != $comment->updated_at)
                                            <div>E:{{ $comment->updated_at }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="comment_edit" data-id="{{ $comment->id }}">
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        </div>
                        @auth
                            <div class="dropdown">
                                <ion-icon name="more" style="font-size: 1.5rem" aria-expanded="false"
                                    aria-haspopup="true" data-toggle="dropdown" id="dropdownMenuButton"></ion-icon>
                                <div class="dropdown-menu tx-13" style="right: 0;">
                                    @if ($comment->user->id == Auth::user()->id)
                                        <button
                                            class="dropdown-item btn_edit">{{ __('pages.readArticle.comment.actions.edit') }}</button>
                                    @endif
                                    @if ($comment->user->id == Auth::user()->id || Auth::user()->id == $article->user->id)
                                        <form action="{{ url('Read/Comment/Delete') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $comment->id }}">
                                            <button class="dropdown-item"
                                                type="submit">{{ __('pages.readArticle.comment.actions.delete') }}</button>
                                        </form>
                                    @endif
                                    <button class="dropdown-item btn_refer" data-id="{{ $comment->id }}"
                                        data-num="{{ $i }}">{{ __('pages.readArticle.comment.actions.refer') }}</button>
                                </div>
                            </div>
                        @endauth
                    </div>
                    @foreach ($comment->replies as $reply)
                        <div class="card col-12 p-3 mb-2"
                            style="margin-right: -10px;display: flex; flex-direction: row-reverse; gap: 10px; justify-content: space-between;">
                            <div style="display: flex; flex-direction: row-reverse; gap: 10px;">
                                @if (!empty($reply->user->img))
                                    <img src="{{ $reply->user->img }}" alt=""
                                        title="{{ $reply->user->name }}">
                                @else
                                    <div class="avatar bg-info rounded-circle" style="width:50px;height:50px"
                                        title="{{ $reply->user->name }}">
                                        {{ $reply->user->name[0] }}
                                    </div>
                                @endif
                                <div style="display: flex;flex-direction: column;">
                                    <div
                                        style="gap: 10px; display: flex; align-items: flex-end; flex-direction: row-reverse;">
                                        <strong>{{ $reply->user->name }}</strong>
                                        <div style="font-size: 0.6rem">
                                            <div class="time">A:{{ $reply->created_at }}</div>
                                            @if ($reply->created_at != $reply->updated_at)
                                                <div>E:{{ $reply->updated_at }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="comment_edit" data-id="{{ $reply->id }}">
                                        {{ $reply->comment }}
                                    </div>
                                </div>
                            </div>
                            @auth
                                <div class="dropdown">
                                    <ion-icon name="more" style="font-size: 1.5rem" aria-expanded="false"
                                        aria-haspopup="true" data-toggle="dropdown" id="dropdownMenuButton"></ion-icon>
                                    <div class="dropdown-menu tx-13" style="right: 0;">
                                        @if ($reply->user->id == Auth::user()->id)
                                            <button
                                                class="dropdown-item btn_edit">{{ __('pages.readArticle.comment.actions.edit') }}</button>
                                        @endif
                                        @if ($reply->user->id == Auth::user()->id || Auth::user()->id == $article->user->id)
                                            <form action="{{ url('Read/Comment/Delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $reply->id }}">
                                                <button class="dropdown-item"
                                                    type="submit">{{ __('pages.readArticle.comment.actions.delete') }}</button>
                                            </form>
                                        @endif
                                        <button class="dropdown-item btn_refer" data-id="{{ $comment->id }}"
                                            data-num="{{ $i }}">{{ __('pages.readArticle.comment.actions.refer') }}</button>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <hr>
@endif
<div class="row">
    <h3 class="card col-12 text-left mb-3 p-3">{{ __('pages.readArticle.recommend') }}</h3>
    @foreach ($recommend_articles as $article)
        {{-- {{ $article }} --}}
        <a href="{{ url('Read/' . $article->id_user . '/' . $article->id) }}" class="col-md-4 col-lg-4 card_art"
            style="color:inherit;">
            <div class="card">
                <img alt="Image" class="img-fluid card-img-top" src="{{ $article->bgArticle }}">
                <div class="card-body ">
                    <p class="card-text">{{ $article->title }}</p>
                </div>
            </div>
        </a>
    @endforeach
    @if (sizeof($recommend_articles) == 0)
        <div class="col-12">
            <div class="card custom-card" style="display:flex; align-items:center; justify-content:space-between;">
                <strong class="m-0 p-2"
                    style="font-style: italic">{{ __('pages.readArticle.recommend.message') }}</strong>
            </div>
        </div>
    @endif
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<script>
    // Edit Comment
    let btn_edit = document.getElementsByClassName('btn_edit');
    let comment_edit = document.getElementsByClassName('comment_edit');
    for (let i = 0; i < btn_edit.length; i++) {
        btn_edit[i].addEventListener('click', () => {
            let message = comment_edit[i].innerHTML;
            comment_edit[i].innerHTML = `
                    @auth
                        <form action="{{ url('Read/Comment/Edit') }}"  method="POST" style="display: flex; flex-direction: row-reverse; align-items: center; gap: 10px;">
                            @csrf
                            <input type="hidden" name="id" value="${comment_edit[i].getAttribute('data-id')}">
                            <textarea class="form-control text-left" name="comment" placeholder="{{ __('pages.readArticle.comment.placeholder') }}" cols="50">${message}</textarea>
                            <button class="btn btn-primary" type="submit">{{ __('pages.readArticle.comment.add') }}</button>
                        </form>
                    @endauth
                `;
        });
    }

    // refer To OTher Comment
    let btn_refer = document.getElementsByClassName('btn_refer');
    let comment_box = document.getElementsByClassName('comment_box');
    for (let i = 0; i < btn_refer.length; i++) {
        btn_refer[i].addEventListener('click', () => {
            console.log(comment_box[btn_refer[i].getAttribute('data-num')])
            comment_box[btn_refer[i].getAttribute('data-num')].innerHTML += `
                    @auth
                        <form action="{{ url('/Read/' . $article->user->id . '/' . $article->id . '/Comment/Refer') }}" method='POST' class="card col-12 p-3 mb-2" style="margin-right: -10px;display: flex; flex-direction: row-reverse; gap: 10px;">
                            @csrf
                            @if (!empty(Auth::user()->img))
                                    <img src="{{ Auth::user()->img }}" alt="" title="{{ Auth::user()->name }}">
                                @else
                                    <div class="avatar bg-info rounded-circle" style="width:50px;height:50px"
                                        title="{{ Auth::user()->name }}">
                                        {{ Auth::user()->name[0] }}
                                    </div>
                            @endif
                            <div style='display: flex; flex-direction: column; align-items: flex-start; gap: 10px;width: 95%;'>
                                <input type="hidden" name="refer" value="${btn_refer[i].getAttribute('data-id')}">
                                <textarea class="form-control text-left" name="comment" placeholder="{{ __('pages.readArticle.comment.placeholder') }}" cols="50"></textarea>
                                <button class="btn btn-primary" type="submit">{{ __('pages.readArticle.comment.add') }}</button>
                            </div>
                        </form>
                    @endauth
                `;
        });
    }

    // Copy Link Article
    $(".copy_btn").on('click', function() {
        let linkSite = location.href;
        navigator.clipboard
            .writeText(linkSite)
            .then(() => {
                console.log("Now You Have a Link..");
            })
            .catch((error) => {
                console.error("Failed to copy:", error);
            });
    });
</script>
@endsection
