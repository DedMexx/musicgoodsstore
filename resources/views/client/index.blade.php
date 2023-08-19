@extends('layouts.list')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/client.css')}}">
@endsection
@section('add', 'нового клиента')
@section('searchPlaceholder', 'ФИО, E-mail или номер телефона')
@section('list')
    <div class="listHeader">
        <div class="listCheckOrders">Посмотреть покупки</div>
        <div class="listFIO">ФИО</div>
        <div class="listEmail">E-mail</div>
        <div class="listPhone">Телефон</div>
        <div class="update">Изменить</div>
        <div class="delete">Удалить</div>
    </div>
    @foreach($table as $row)
        <div class="item">
            <div class="listCheckOrders"><a href="{{route('order.index', ['client' => $row->id])}}">Перейти к заказам</a></div>
            <div class="listFIO"><a href="{{route('client.show', ['client' => $row])}}">{{$row->last_name}} {{$row->first_name}} {{$row->third_name}}</a></div>
            <div class="listEmail"><a href="mailto:{{$row->email}}">{{$row->email}}</a></div>
            <div class="listPhone"><a href="tel:{{$row->phone}}">{{$row->phone}}</a></div>
            <div class="update">
                <form method="GET" action="{{route('client.edit', ['client' => $row])}}">
                    @csrf
                    <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg"
                           alt="Изменить">
                </form>
            </div>
            <div class="delete">
                <form method="POST" action="{{route('client.destroy', ['client' => $row])}}">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg"
                           alt="Удалить">
                </form>
            </div>
        </div>
    @endforeach
@endsection
