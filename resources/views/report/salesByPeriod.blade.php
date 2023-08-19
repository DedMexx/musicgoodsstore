@extends('report.main')
@section('sales', 'selectedMenu')
@section('salesByPeriod', 'selectedMenu')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/order.css')}}">
    <link rel="stylesheet" href="{{asset('stylesheets/salesByPeriod.css')}}">
@endsection
@section('search')
    <div class="search-wrapper search-by-date">
        <form action="{{route('report.'.$tableName)}}" method="get" class="search">
            @include('report.searchByDate')
        </form>
    </div>
@endsection
@section('list')
    <div class="listHeader">
        <div class="listShowOrder"></div>
        <div class="listDate">Дата</div>
        <div class="listCost">Стоимость</div>
        <div class="listPaid">Выплачено</div>
        <div class="listCount">Количество товара</div>
        <div class="listClient">Клиент</div>
    </div>
    @foreach($table as $key => $row)
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
            <div class="listCount">{{$row->count}}</div>
            <div class="listClient">
                <a href="{{route('client.show', ['client' => $row->client_id])}}">
                    {{$row->last_name}} {{$row->first_name}} {{$row->third_name}}
                </a>
                <a href="mailto:{{$row->email}}">{{$row->email}}</a>
                <a href="tel:{{$row->phone}}">{{$row->phone}}</a>
            </div>
        </div>
    @endforeach
    <div class="item bold">
        <div class="listTotal">Итого</div>
        <div class="listTotalCost">{{number_format($totalCost, 2)}}₽</div>
        <div class="listTotalPaid">{{number_format($totalPaid, 2)}}₽</div>
        <div class="listCount">{{$totalCount}}</div>
        <div class="listCountOfOrders">Всего заказов: {{$key+1}}</div>
    </div>
@endsection
