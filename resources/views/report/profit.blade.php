@php
    use App\Models\Order;
    use App\Models\Product;
@endphp

@extends('report.main')

@section('profit', 'selectedMenu')
@section('searchPlaceholder', 'Название категории')

@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/profit.css')}}">
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
        <div class="listDate">Дата</div>
        <div class="listName">Название товара</div>
        <div class="listCount">Количество</div>
        <div class="listProfit">Прибыль</div>
        <div class="listTotalProfit">Общая прибыль</div>
    </div>

    @foreach($table as $key => $row)
        @if($key === 0 || $table[$key-1]->name === null)
            <div class="item">
            @if ($row->order_id)
                    <div class="listDate">{{Order::find($row->order_id)->date}}</div>
                    <div class="itemComposition">
            @endif
        @endif
        @if ($row->name !== null)
            <div class="listCompositionItem">
                <div class="listName"><a href="{{route('product.show', ['product' => Product::where('name', $row->name)->first()])}}">{{$row->name}}</a></div>
                <div class="listCount">{{$row->count}}</div>
                <div class="listProfit">{{number_format($row->profit, 2)}}₽</div>
            </div>
        @elseif ($row->order_id)
            </div>
            <div class="listTotalProfit bold">{{number_format($row->profit, 2)}}₽</div>
            </div>
        @else
            <div class="listTotal bold">ИТОГО</div>
            <div class="listTotalProfit bold">{{number_format($row->profit, 2)}}₽</div>
            </div>
        @endif
    @endforeach
@endsection
