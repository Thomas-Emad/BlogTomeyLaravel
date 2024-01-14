@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('title')
    {{ __('pages.title.owner.roles') }}
@endsection
@section('content')
    <!--Row-->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin mt-3">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('pages.owner.roles.table') }}</h4>
                        <div>
                            <div><a href="{{ route('roles.create') }}"
                                    class="btn btn-outline-primary">{{ __('pages.owner.roles.table.create') }}</a>
                            </div>
                        </div>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">{{ __('pages.owner.roles.table.message') }}</p>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-lg-20p">#</th>
                                    <th class="wd-lg-20p">{{ __('pages.owner.roles.table.col.name') }}</th>
                                    <th class="wd-lg-20p">{{ __('pages.owner.roles.table.col.count') }}</th>
                                    <th class="wd-lg-20p">{{ __('pages.owner.roles.table.col.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->users->count() }}</td>
                                        <td>
                                            @if ($role->id !== 1)
                                                <a data-effect="effect-scale" data-toggle="modal" href="#info"
                                                    class="btn btn-sm btn-primary modalRoleInfo"
                                                    data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                                    <i class="las la-info"></i>
                                                </a>
                                                <a href="{{ route('roles.edit', ['role' => $role->id]) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                <a data-effect="effect-scale" data-toggle="modal" href="#delete"
                                                    class="btn btn-sm btn-danger modalRoleDelete"
                                                    data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php ++$i; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>

    <!-- row closed  -->
    <!-- Modal effects => Info -->
    <div class="modal" id="info">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('pages.owner.roles.modal.info') }}</h6><button aria-label="Close"
                        class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <ul id='treeview1'>
                        <li><a class='active' href='#'></a>
                            <ul>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary w-100" data-dismiss="modal"
                        type="button">{{ __('pages.owner.roles.modal.info.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal effects  => delete -->
    <div class="modal" id="delete">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="roles/destroy" method="POST" class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('pages.owner.roles.modal.delete') }}</h6><button aria-label="Close"
                        class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id='idRole' value="">
                    <input type="text" name="title" id='titleRole' class="form-control" disabled>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-danger"
                        type="submit">{{ __('pages.owner.roles.modal.delete.delete') }}</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                        type="button">{{ __('pages.owner.roles.modal.delete.close') }}</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Print Perm for this role
            $(".modalRoleInfo").on("click", function() {
                let roleID = $(this).attr("data-id");
                $("#treeview1 li a").html($(this).attr("data-name"))
                if (roleID) {
                    $.ajax({
                        url: "/admin/role/" + roleID,
                        type: 'GET',
                        dataType: "json",
                        success: function(response) {
                            $("#treeview1 li ul").empty()
                            $.each(response, function(name) {
                                $("#treeview1 li ul").append("<li>" + name + "</li>");
                            })
                        }
                    });
                } else {
                    console.log("Error For Ajax")
                }
            })

            // Add date For model Delete
            $(".modalRoleDelete").on("click", function() {
                $("#delete form #idRole").val($(this).attr("data-id"))
                $("#delete form #titleRole").val($(this).attr("data-name"))
            })
        })
    </script>
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
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <!-- Internal Treeview js -->
    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection
