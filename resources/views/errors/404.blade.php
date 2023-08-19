@extends('layouts.main')
@section('title', '404. Страница не найдена')
@section('innerHead')
    <link rel="stylesheet" href="{{asset('stylesheets/errors.css')}}">
@endsection
@section('main')
    <div class="error">
            <img src="{{asset('images/errors/404.png')}}" class="error404img" alt="404">
        <div class="errorText">
            Такой страницы не существует
        </div>
    </div>
@endsection
