@extends('report.main')
@section('sales', 'selectedMenu')
@section('salesByManufacturer', 'selectedMenu')
@section('searchPlaceholder', 'Название производителя')
@section('search')
    <div class="search-wrapper">
        <form action="{{route('report.'.$tableName)}}" method="get" class="search search-block">
            <div>
                @include('report.search')
            </div>
            <div class="search-by-date-wrapper">
                @include('report.searchByDate')
            </div>
        </form>
    </div>
@endsection
@section('list')
    <div class="listHeader">
        <div class="listName">Название производителя</div>
        <div class="listCount">Продано товаров</div>
        <div class="listCountOfOrders">Количество заказов</div>
        <div class="listOrdersSum">Общая сумма заказов</div>
    </div>
    @foreach($table as $row)
        <div class="item">
            <div class="listName">{{$row->name}}</div>
            <div class="listCount">{{$row->total_count}}</div>
            <div class="listCountOfOrders">{{$row->orders_count}}</div>
            <div class="listOrdersSum">{{number_format($row->costs_sum, 2)}}₽</div>
        </div>
    @endforeach
@endsection
