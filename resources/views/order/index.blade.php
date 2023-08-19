@php
    use App\Models\Payment;
    use App\Models\Client;
@endphp
@extends('layouts.list')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/order.css')}}">
@endsection
@section('searchPlaceholder', 'ФИО клиента, E-mail, телефон или дата')
@section('add', 'новый заказ')
@section('list')
    <div class="listHeader">
        <div class="listShowOrder"></div>
        <div class="listDate">Дата</div>
        <div class="listCost">Стоимость</div>
        <div class="listPaid">Выплачено</div>
        <div class="listClient">Клиент</div>
{{--        <div class="update">Изменить</div>--}}
        <div class="delete">Удалить</div>
    </div>
    @foreach($table as $row)
        <div class="item">
            <div class="listShowOrder"><a href="{{route('order.show', ['order' => $row])}}">Перейти к заказу</a></div>
            <div class="listDate">{{$row->date}}</div>
            <div class="listCost">{{number_format($row->cost, 2)}}₽</div>
            <div class="listPaid bold">
                <span class="@if($row->paid >= $row->cost) green @else mainRed @endif">
                    @if($row->paid > 0){{number_format($row->paid, 2)}}₽
                    @else Выплат не поступало
                    @endif
                </span>
            </div>
            <div class="listClient">
                <a href="{{route('client.show', ['client' => $row->client_id])}}">
                    {{$row->last_name}} {{$row->first_name}} {{$row->third_name}}
                </a>
                <a href="mailto:{{$row->email}}">{{$row->email}}</a>
                <a href="tel:{{$row->phone}}">{{$row->phone}}</a>
            </div>
{{--            <div class="update">--}}
{{--                <form method="GET" action="{{route('order.edit', ['order' => $row])}}">--}}
{{--                    @csrf--}}
{{--                    <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg"--}}
{{--                           alt="Изменить">--}}
{{--                </form>--}}
{{--            </div>--}}
            <div class="delete">
                <form method="POST" action="{{route('order.destroy', ['order' => $row])}}">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg"
                           alt="Удалить">
                </form>
            </div>
        </div>
    @endforeach
@endsection
