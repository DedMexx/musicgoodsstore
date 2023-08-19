@extends('layouts.main')
@section('report', 'selectedMenu')
@section('innerHead')
    <link rel="stylesheet" href="{{asset('stylesheets/list.css')}}">
    <link rel="stylesheet" href="{{asset('stylesheets/report.css')}}">
    @yield('innerHeadList')
@endsection
@section('main')
    <h1 class="listTitle">{{$title}}</h1>
    @yield('search')
    @if (!$table->isEmpty())
        <div class="list">
            @yield('list')
        </div>
        @if ($table instanceof Illuminate\Pagination\LengthAwarePaginator)
            {{$table->links()}}
        @endif
    @else
        <div class="searchNotFound">
            По запросу ничего не удалось найти
        </div>
    @endif
@endsection
@section('title', $title)
