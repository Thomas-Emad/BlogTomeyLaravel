<!-- Sidebar-right-->
@auth
    <div class="sidebar sidebar-left sidebar-animate">
        <div class="panel panel-primary card mb-0 box-shadow">
            <div class="tab-menu-heading border-0 p-3">
                <div class="card-title mb-0">{{ __('layout.sidebarRight.notfiy') }}</div>
                <div class="card-options mr-auto">
                    <a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
                </div>
            </div>
            <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li><a href="#notif" data-toggle="tab" class="active"><i
                                    class="ion ion-md-notifications tx-18  ml-2"></i>
                                {{ __('layout.sidebarRight.notfiy') }}</a>
                        </li>
                        <li><a href="#follows" data-toggle="tab"><i class="ion ion-md-contacts tx-18 ml-2"></i>
                                {{ __('layout.sidebarRight.follow') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane  active" id="notif">
                        <div class="list-group list-group-flush ">
                            @foreach (Auth::user()->notifications->take(5) as $notification)
                                <?php
                                $article = \App\Models\Article::where('id', $notification->data['id_article'])->first();
                                $author = \App\Models\User::where('id', $notification->data['id_author'])->first();
                                ?>
                                <a class="d-flex p-3 border-bottom"
                                    @if ($notification->read_at === null) style="background-color:#dddddd45;" @endif
                                    href="{{ route('read', ['user' => $article->id_user, 'id' => $article->id]) }}">
                                    <div>
                                        <img src="{{ $article->bgArticle }}" style="width: 35px; height: 35px;"
                                            class="notifyimg bg-primary">
                                    </div>
                                    <div class="mr-3">
                                        <h5 class="notification-label mb-1">
                                            {{ \Str::limit($article->title, 15) }}
                                        </h5>
                                        <div class="notification-subtext">
                                            {{ $author->name }}
                                            || {{ $notification->created_at }}
                                        </div>
                                    </div>
                                    <div class="mr-auto">
                                        <i class="las la-angle-left text-left text-muted"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane  " id="follows">
                        @foreach (\App\Models\User::whereIn('id', Auth::user()->follow->pluck('id_author'))->select('id', 'name', 'img')->get() as $author)
                            <div class="list-group list-group-flush ">
                                <div class="list-group-item d-flex  align-items-center">
                                    <a href="{{ url('articles', ['id' => $author->id]) }}" class="ml-2">
                                        @if (!empty($author->img))
                                            <img src="{{ url('files/' . $author->img) }}" alt=""
                                                onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"
                                                style="width:30px;height:30px;border-radius:100px">
                                        @else
                                            <div class="avatar bg-info rounded-circle" style="width:30px;height:30px">
                                                {{ $author->name[0] }}
                                            </div>
                                        @endif
                                    </a>
                                    <a href="{{ url('articles', ['id' => $author->id]) }}" style="color:inherit">
                                        <div class="font-weight-semibold">
                                            {{ $author->name }}</div>
                                    </a>
                                    <div class="mr-auto">
                                        <a href="{{ route('profile', ['id' => $author->id]) }}"
                                            class="btn btn-sm btn-light"><i class="fe fe-user"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endauth
<!--/Sidebar-right-->
