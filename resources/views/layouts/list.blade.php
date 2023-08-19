@extends($tableName.'.main')
@section('innerHead')
    <link rel="stylesheet" href="{{asset('stylesheets/list.css')}}">
    @yield('innerHeadList')
@endsection
@section('main')
    <h1 class="listTitle">{{$title}}</h1>
    <div class="addNew">
        <a class="addNewLink" href="{{route($tableName.'.create')}}">Добавить @yield('add')</a>
    </div>
    @include('layouts.search')
    @if (!$table->isEmpty())
        <div class="list">
            @yield('list')
        </div>
        {{$table->links()}}
    @else
        <div class="tableEmpty">
            По запросу ничего не удалось найти
        </div>
    @endif
    <script src="{{asset('scripts/lists/list.js')}}"></script>
@endsection
@yield('innerFooter')
