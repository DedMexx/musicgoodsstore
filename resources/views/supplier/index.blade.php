@extends('layouts.list')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/supplier.css')}}">
@endsection
@section('searchPlaceholder', 'Название, E-mail, телефон или ФИО')
@section('add', 'нового поставщика')
@section('list')
    <div class="listHeader">
        <div class="listName">Название</div>
        <div class="listEmail">E-mail</div>
        <div class="listPhone">Телефон</div>
        <div class="listFIO">ФИО ответственного</div>
        <div class="update">Изменить</div>
        <div class="delete">Удалить</div>
    </div>
    @foreach($table as $row)
        <div class="item">
            <div class="listName"><a href="{{route('supplier.show', ['supplier' => $row])}}">{{$row->name}}</a></div>
            <div class="listEmail"><a class="emailLink" href="mailto:{{$row->email}}">{{$row->email}}</a></div>
            <div class="listPhone"><a href="tel:{{$row->phone}}">{{$row->phone}}</a></div>
            <div
                class="listFIO">{{$row->last_name}} {{$row->first_name}} {{$row->third_name}}</div>

            <div class="update">
                <form method="GET" action="{{route('supplier.edit', ['supplier' => $row])}}">
                    @csrf
                    <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg"
                           alt="Изменить">
                </form>
            </div>
            <div class="delete">
                <form method="POST" action="{{route('supplier.destroy', ['supplier' => $row])}}">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg"
                           alt="Удалить">
                </form>
            </div>
        </div>
    @endforeach
@endsection
