@extends('layouts.list')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/specification.css')}}">
@endsection
@section('add', 'новую характеристику')
@section('searchPlaceholder', 'Название характеристики')
@section('list')
        <div class="listHeader">
            <div class="listName">Название</div>
            <div class="listDescription">Описание</div>
            <div class="update">Изменить</div>
            <div class="delete">Удалить</div>
        </div>
        @foreach($table as $row)
            <div class="item">
                <div class="listName">{{$row->name}}</div>
                <div class="listDescription">{{$row->description}}</div>
                <div class="update">
                    <form method="GET" action="{{route('specification.edit', ['specification' => $row])}}">
                        @csrf
                        <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg" alt="Изменить">
                    </form>
                </div>
                <div class="delete">
                    <form method="POST" action="{{route('specification.destroy', ['specification' => $row])}}">
                        @csrf
                        @method('DELETE')
                        <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg" alt="Удалить">
                    </form>
                </div>
            </div>
        @endforeach
@endsection
