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
    {{ __('pages.title.owner.users') }}
@endsection
@section('content')
    <!--Row-->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin mt-3">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('pages.owner.users.table') }}</h4>
                        <strong>C: {{ $users->count() }}</strong>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">{{ __('pages.owner.users.table.message') }}</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example2">
                            <thead>
                                <tr>
                                    <th class="wd-lg-8p"><span>{{ __('pages.owner.users.table.col.img') }}</span></th>
                                    <th class="wd-lg-8p"><span>{{ __('pages.owner.users.table.col.user') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.users.table.col.created') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.users.table.col.status') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.users.table.col.active') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.users.table.col.mail') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.users.table.col.articles') }}</span>
                                    </th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.users.table.col.reports') }}</span></th>
                                    <th class="wd-lg-20p"><span>{{ __('pages.owner.users.table.col.lastLogin') }}</span>
                                    </th>
                                    <th class="wd-lg-20p">{{ __('pages.owner.users.table.col.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            @if (!empty($user->img))
                                                <img src="{{ asset('files/' . $user->img) }}" alt=""
                                                    onerror="this.src='{{ URL::asset('assets/img/faces/6.jpg') }}'"
                                                    style="width:50px;height:50px;border-radius:100px">
                                            @else
                                                <div class="avatar bg-info rounded-circle" style="width:50px;height:50px">
                                                    {{ $user->name[0] }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            {{ $user->created_at->format('Y/m/d') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($user->status == 'open')
                                                <span class="label text-success d-flex">
                                                    <div class="dot-label bg-success ml-1"></div>
                                                    {{ __('pages.owner.users.table.col.status.open') }}
                                                </span>
                                            @else
                                                <span class="label text-danger d-flex">
                                                    <div class="dot-label bg-danger ml-1"></div>
                                                    {{ __('pages.owner.users.table.col.status.block') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($user->email_verified_at !== null)
                                                <span class="label text-muted d-flex">
                                                    <div class="dot-label bg-gray-300 ml-1"></div>
                                                    {{ __('pages.owner.users.table.col.active.active') }}
                                                </span>
                                            @else
                                                <span class="label text-warning d-flex">
                                                    <div class="dot-label bg-warning ml-1"></div>
                                                    {{ __('pages.owner.users.table.col.active.inActive') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#">{{ $user->email }}</a>
                                        </td>
                                        <td>
                                            <a>{{ $user->articles()->count() }}</a>
                                        </td>
                                        <td>
                                            <a href="#">{{ $user->reports }}</a>
                                        </td>
                                        <td>
                                            <a>{{ $user->last_login }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('profile', ['id' => $user->id]) }}"
                                                class="btn btn-sm btn-primary" target="__blank">
                                                <i class="las la-search"></i>
                                            </a>
                                            <a href="{{ route('userDestroy', ['id' => $user->id]) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="las la-trash"></i>
                                            </a>
                                            @can('rolesPermissions')
                                                <a href="{{ route('users.edit', ['id' => $user->id]) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fe fe-command"></i>
                                                </a>
                                            @endcan
                                            @if ($user->status == 'open')
                                                <a href="{{ route('userBanned', ['id' => $user->id]) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fe fe-slash"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('userBanned', ['id' => $user->id]) }}"
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
@endsection
