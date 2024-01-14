@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ __('pages.title.owner.roles.edit') }}
@endsection
@section('content')
    <!--Row-->
    <div class="row row-sm mt-4">
        <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST" class="card col-12 p-2">
            @csrf
            @method('PATCH')
            <input type="text" name="name" class="form-control" id="nameRole"
                placeholder="{{ __('pages.owner.roles.edit.placeholder') }}" value="{{ old('name', $role->name) }}">

            @foreach ($permission as $perm)
                <div class="mt-2">
                    <label class="ckbox"><input type="checkbox" @checked((is_array(old('permission')) && in_array($perm->name, old('permission'))) || in_array($perm->id, $rolePermissions)) name="permission[]"
                            value="{{ $perm->name }}"><span>{{ $perm->name }}</span></label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-success w-100 mt-2">{{ __('pages.owner.roles.edit.save') }}</button>
        </form>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
