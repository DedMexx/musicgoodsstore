@extends($tableName.'.main')
@section('innerHead')
    <link rel="stylesheet" href="{{asset('stylesheets/show.css')}}">
    @yield('innerHeadShow')
@endsection
@section('main')
@yield('mainShow')
    <script src="{{asset('scripts//shows/show.js')}}"></script>
@endsection
