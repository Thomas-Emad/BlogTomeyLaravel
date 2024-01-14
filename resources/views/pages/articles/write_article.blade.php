@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection
@section('title')
    @isset($article)
        {{ __('pages.title.editArticle') }}
    @else
        {{ __('pages.title.createArticle') }}
    @endisset
@endsection
@section('page-header')
@endsection
@section('content')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'editimage', 'wordcount'
            ],
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        });
    </script>

    <!-- row -->
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form
                        action="@isset($article) {{ route('articles.update', $article->id) }} @else {{ route('articles.store') }} @endisset"
                        method="POST" id="formContent" dir="ltr" enctype="multipart/form-data">
                        @csrf
                        @isset($article)
                            @method('PATCH')
                        @else
                            @method('POST')
                        @endisset
                        <div class="row mb-2">
                            <div class="col-12">
                                <label for="inputName" class="form-label">{{ __('pages.writeEdit.title') }}</label>
                                <input type="text" class="form-control" id="inputName" name="title"
                                    placeholder="{{ __('pages.writeEdit.title.placeholder') }}"
                                    value="{{ old('title', isset($article) ? $article->title : '') }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="custom-file">
                                    <input class="custom-file-input" id="customFile" type="file" name="bgArticle">
                                    <label class="custom-file-label"
                                        for="customFile">{{ __('pages.writeEdit.bgArticle') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 pt-2">
                                <label for="comment"
                                    style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: space-between;">
                                    <div
                                        class="main-toggle main-toggle-success @if (old('comment', (isset($article) ? ($article->comment == 'allow' ? 'on' : 'off') : 'off') == 'on')) on @else off @endif">
                                        <span></span>
                                    </div>
                                    <p class="form-label">{{ __('pages.writeEdit.comment') }}</p>
                                </label>
                                <input type="checkbox" name="comment" id="comment" @checked(old('comment'))
                                    @checked(old('comment') || (isset($article) && $article->comment == 'allow')) hidden>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <p class="form-label">{{ __('pages.writeEdit.types') }}</p>
                                <select class="form-control select2" name="id_types[]" multiple="multiple" class="w-100">
                                    @foreach ($types as $item)
                                        <option value="{{ $item->id }}" @selected(in_array($item->id, old('id_types', isset($types_article) ? $types_article : '') ? old('id_types', isset($types_article) ? $types_article : '') : []))>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="ql-wrapper ql-wrapper-demo bg-gray-100">
                            <textarea id="myeditorinstance" name="content">{!! old('content', isset($article) ? $article->content : '') !!}</textarea>
                        </div>
                        <button class="btn btn-success btn-block mt-2" type="submit">
                            @isset($article)
                                {{ __('pages.writeEdit.save') }}
                            @else
                                {{ __('pages.writeEdit.add') }}
                            @endisset
                        </button>
                    </form>
                </div>
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
    <script src="{{ URL::asset('assets/js/form-editor.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
