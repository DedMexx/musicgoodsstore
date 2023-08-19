@extends($tableName.'.main')
@section('innerHead')
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>--}}
    <link rel="stylesheet" href="{{asset('stylesheets/form.css')}}">
    @yield('innerHeadForm')
@endsection
@section('main')
@if (count($errors) > 0)
    <script>
        Swal.fire({
            title: 'Ошибка',
            text: '{{$errors->first()}}',
            icon: 'error',
            buttonsStyling: false
        });
    </script>
@endif
    @yield('form')
<script src="{{asset('scripts/forms/form.js')}}"></script>
    @yield('forScripts')
@endsection
