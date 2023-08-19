@extends('report.main')
@section('tbr', 'selectedMenu')
@section('searchPlaceholder', 'Название категории')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/tbr.css')}}">
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
        <div class="listOperation">Операция</div>
        <div class="listSum">Сумма</div>
    </div>
    @foreach($table as $row)
        <div class="item">
            <div class="listDate">{{$row->date}}</div>
            <div class="listOperation">@if($row->cost_per_day)Расход средств @else Поступление средств @endif</div>
            <div class="listSum">@if($row->cost_per_day)-{{number_format($row->cost_per_day, 2)}}₽
                @else +{{number_format($row->income_per_day, 2)}}₽@endif</div>
        </div>
    @endforeach
    <div class="item">
        <div class="listTotal">ИТОГО</div>
        <div class="listTotalProfit @if($balance >= 0) green @else mainRed @endif">{{number_format($balance, 2)}}₽</div>
    </div>
@endsection
