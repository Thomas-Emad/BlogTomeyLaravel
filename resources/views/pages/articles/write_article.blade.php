@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
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

        // tinymce.init({
        //     selector: 'textarea#myeditorinstance',
        //     plugins: [
        //         'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        //         'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        //         'insertdatetime', 'media', 'table', 'editimage', 'wordcount'
        //     ],
        //     toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',

        //     /* enable title field in the Image dialog*/
        //     image_title: true,
        //     /* enable automatic uploads of images represented by blob or data URIs*/
        //     automatic_uploads: true,
        //     /*
        //       URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
        //       images_upload_url: 'postAcceptor.php',
        //       here we add custom filepicker only to Image dialog
        //     */
        //     file_picker_types: 'image',
        //     /* and here's our custom image picker*/
        //     file_picker_callback: (cb, value, meta) => {
        //         const input = document.createElement('input');
        //         input.setAttribute('type', 'file');
        //         input.setAttribute('accept', 'image/*');

        //         input.addEventListener('change', (e) => {
        //             const file = e.target.files[0];

        //             const reader = new FileReader();
        //             reader.addEventListener('load', () => {
        //                 /*
        //                   Note: Now we need to register the blob in TinyMCEs image blob
        //                   registry. In the next release this part hopefully won't be
        //                   necessary, as we are looking to handle it internally.
        //                 */
        //                 const id = 'blobid' + (new Date()).getTime();
        //                 const blobCache = tinymce.activeEditor.editorUpload.blobCache;
        //                 const base64 = reader.result.split(',')[1];
        //                 const blobInfo = blobCache.create(id, file, base64);
        //                 blobCache.add(blobInfo);

        //                 /* call the callback and populate the Title field with the file name */
        //                 cb(blobInfo.blobUri(), {
        //                     title: file.name
        //                 });
        //             });
        //             reader.readAsDataURL(file);
        //         });

        //         input.click();
        //     },
        //     content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        // });
    </script>

    <!-- row -->
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="POST" id="formContent" dir="ltr">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-12">
                                <label for="inputName" class="form-label">Title Article</label>
                                <input type="text" class="form-control" id="inputName" name="title"
                                    placeholder="Title Article?.." value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <label for="bgArticle" class="form-label">Background Article</label>
                                <input type="text" class="form-control" id="bgArticle" name="bgArticle"
                                    placeholder="Writle Url Background Article?.." value="{{ old('bgArticle') }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12 col-sm-12">
                                <p class="form-label">Type Your Article</p>
                                <select class="form-control select2" name="id_types[]" multiple="multiple">
                                    @foreach ($types as $item)
                                        <option value="{{ $item->id }}" @selected(in_array(1, old('id_types') ? old('id_types') : []))>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="ql-wrapper ql-wrapper-demo bg-gray-100">
                            <textarea id="myeditorinstance" name="content">{!! old('content') !!}</textarea>
                        </div>
                        <button class="btn btn-success btn-block mt-2" type="submit">Add Article</button>
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
