@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.owner.articles') }}
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin mt-3">
            <div class="card p-2 searchBox">
                <input type="text" class="form-control text-left" name="title"
                    placeholder="{{ __('pages.owner.articles.search.placeholder') }}" value="{{ request()->segment(3) }}">
                <button class="btn btn-primary mt-2" type="submit">{{ __('pages.owner.articles.search.btn') }}</button>
            </div>
        </div>
    </div>
    <!--Row-->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('pages.owner.articles.table') }}</h4>
                        <div>
                            <p class="m-0"><strong><i class="fe fe-book-open"></i>: {{ $articles->count() }}</strong>
                            </p>
                            <p class="m-0"><strong><i class="fe fe-slash"></i>:
                                    {{ $articles->whereNotNull('hidden')->count() }}</strong></p>
                        </div>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">{{ __('pages.owner.articles.table.message') }}</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example2">
                            <thead>
                                <tr>
                                    <th class="wd-lg-8p"><span>{{ __('pages.owner.articles.table.col.img') }}</span></th>
                                    <th class="wd-lg-8p"><span>{{ __('pages.owner.articles.table.col.title') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.articles.table.col.user') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.articles.table.col.status') }}</span>
                                    </th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.articles.table.col.created') }}</span>
                                    </th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.articles.table.col.views') }}</span>
                                    </th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.articles.table.col.comments') }}</span>
                                    </th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.articles.table.col.reports') }}</span>
                                    </th>
                                    <th class="wd-lg-20p">{{ __('pages.owner.articles.table.col.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>
                                            <img alt="avatar" class="rounded-circle avatar-md mr-2"
                                                src="{{ asset('bgArticles/' . $article->bgArticle) }}">
                                        </td>
                                        <td>{{ \Str::limit($article->title, 10) }}</td>
                                        <td>{{ $article->user->name }}</td>
                                        <td class="text-center">
                                            @if ($article->hidden == null)
                                                <span class="label text-success d-flex">
                                                    <div class="dot-label bg-success ml-1"></div>
                                                    {{ __('pages.owner.articles.table.col.status.open') }}
                                                </span>
                                            @else
                                                <span class="label text-danger d-flex">
                                                    <div class="dot-label bg-danger ml-1"></div>
                                                    {{ __('pages.owner.articles.table.col.status.banned') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $article->created_at->format('Y/m/d') }}
                                        </td>
                                        <td>
                                            <a href="#">{{ $article->watched }}</a>
                                        </td>
                                        <td>
                                            <a>{{ $article->comments()->count() }}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{ $article->reports()->count() }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('profile', ['id' => $article->id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fe fe-user"></i>
                                            </a>
                                            <a href="{{ route('statisticArticle', ['user' => $article->user->id, 'id' => $article->id]) }}"
                                                class="btn btn-sm btn-primary" target="__blank">
                                                <i class="fe fe-activity"></i>
                                            </a>
                                            @can('articles-controll')
                                                <a href="{{ route('editArticle', ['user' => $article->user->id, 'id' => $article->id]) }}"
                                                    class="btn btn-sm btn-info" target="__blank">
                                                    <i class="las la-pen"></i>
                                                </a>
                                                <form style="display: inherit;"
                                                    action="{{ route('delArticle', ['user' => $article->user->id, 'id' => $article->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" name="{{ $article->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                                            class="las la-trash"></i></button>
                                                </form>
                                            @endcan
                                            @if ($article->hidden == null)
                                                <a href="{{ route('statusArticle', ['user' => $article->user->id, 'id' => $article->id]) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fe fe-slash"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('statusArticle', ['user' => $article->user->id, 'id' => $article->id]) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fe fe-briefcase"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <script>
        // Search By input
        $(".searchBox button").on("click", () => {
            window.location.href = $(location).attr("origin") + "/admin/articles/" + $(".searchBox input").val();
        })
    </script>
@endsection
