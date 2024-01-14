@extends('layouts.master')
@section('css')
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.owner.types') }}
@endsection
@section('page-header')
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">{{ __('pages.owner.types.topUsed') }}</h4>
                    </div>
                    <p class="card-description mb-1">{{ __('pages.owner.types.topUsed.message') }}</p>
                    <?php $i = 1; ?>
                    @foreach ($top_types as $item)
                        <div class="list d-flex align-items-center border-bottom py-3">
                            <span class="btn btn-sm btn-success">{{ $i }}</span>
                            <div class="wrapper w-100 mr-3">
                                <p class="mb-0">
                                    <b>{{ $item->type->name }}</b>
                                </p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted ml-1"></i>
                                        <p class="mb-0">{{ __('pages.owner.types.topUsed.used') }} </p>
                                        {{ $item->count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i++; ?>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    <!-- row Types -->
    <div class="row">
        <div class="col-xl-12 ">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ __('pages.owner.types.typesArticle') }}</h4>
                        <a class="modal-effect btn btn-outline-primary" data-effect="effect-scale" data-toggle="modal"
                            href="#modaldemo8" dir="ltr">{{ __('pages.owner.types.typesArticle.add') }}</a>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">{{ __('pages.owner.types.typesArticle.message') }}</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">{{ __('pages.owner.types.typesArticle.col.title') }}
                                    </th>
                                    <th class="wd-20p border-bottom-0">{{ __('pages.owner.types.typesArticle.col.count') }}
                                    </th>
                                    <th class="wd-10p border-bottom-0">{{ __('pages.owner.types.typesArticle.col.time') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">
                                        {{ __('pages.owner.types.typesArticle.col.operating') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($types as $item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->typeArticles->count() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y/m/d') }}</td>
                                        <td>
                                            <a href="#modaldemo6" class="modal-effect btn btn-secondary btn-sm button_edit"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-effect="effect-scale" data-toggle="modal">
                                                <ion-icon name="create" style="font-size: 1.2rem"></ion-icon>
                                            </a>
                                            <a href="#modaldemo5" class=" modal-effect btn btn-danger btn-sm button_del"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-effect="effect-scale" data-toggle="modal">
                                                <ion-icon name="trash" style="font-size: 1.2rem"></ion-icon>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
        <!-- Modal effects [Add New Type] -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="POST" action="{{ route('types.store') }}" class="modal-content modal-content-demo">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('pages.owner.types.typesArticle.modal.add') }}</h6><button
                            aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ __('pages.owner.types.typesArticle.modal.add.input') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-success"
                            type="submit">{{ __('pages.owner.types.typesArticle.modal.add.add') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('pages.owner.types.typesArticle.modal.add.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal effects-->
        <!-- Modal effects [Edit In Name Type] -->
        <div class="modal" id="modaldemo6">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="POST" action="{{ route('types.update', 'error') }}"
                    class="modal-content modal-content-demo">
                    @method('PATCH')
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('pages.owner.types.typesArticle.modal.edit') }}</h6><button
                            aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="id_type" name="id">
                            <input type="text" class="form-control name_type" name="name"
                                placeholder="{{ __('pages.owner.types.typesArticle.modal.edit.input') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-success"
                            type="submit">{{ __('pages.owner.types.typesArticle.modal.edit.save') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('pages.owner.types.typesArticle.modal.edit.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal effects-->
        <!-- Modal effects [Delete Type] -->
        <div class="modal" id="modaldemo5">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="POST" action="{{ route('types.destroy', 'Error Updateing') }}"
                    class="modal-content modal-content-demo">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('pages.owner.types.typesArticle.modal.delete') }}</h6><button
                            aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="id_type" name="id">
                            <input type="text" class="form-control name_type" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger"
                            type="submit">{{ __('pages.owner.types.typesArticle.modal.delete.delete') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">{{ __('pages.owner.types.typesArticle.modal.delete.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal effects-->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        let button_edit = document.getElementsByClassName("button_edit");
        for (let i = 0; i < button_edit.length; i++) {
            button_edit[i].addEventListener('click', () => {
                document.getElementsByClassName("id_type")[0].value = button_edit[i].getAttribute("data-id");
                document.getElementsByClassName("name_type")[0].value = button_edit[i].getAttribute("data-name");
            })
        }

        let button_del = document.getElementsByClassName("button_del");
        for (let i = 0; i < button_del.length; i++) {
            button_del[i].addEventListener('click', () => {
                document.getElementsByClassName("id_type")[1].value = button_del[i].getAttribute("data-id");
                document.getElementsByClassName("name_type")[1].value = button_del[i].getAttribute("data-name");
            })
        }
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
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection
