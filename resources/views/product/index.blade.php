@php
    use App\Models\Category;
    use App\Models\CategoryProduct;
    use App\Models\Manufacturer;
@endphp
@extends('layouts.list')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/product.css')}}">
@endsection
@section('searchPlaceholder', 'Название, категория или производитель')
@section('add', 'новый музыкальный товар')
@section('list')
    <div class="listHeader">
        <div class="listImage">Изображение</div>
        <div class="listName">Название</div>
        <div class="listCategories">Категории</div>
        <div class="quantity">Количество</div>
        <div class="listSellingPrice">Цена продажи</div>
        <div class="listManufacturer">Производитель</div>
        <div class="update">Изменить</div>
        <div class="delete">Удалить</div>
    </div>
    @foreach($table as $row)
        <div class="item @if($row->quantity < 1) outOfStock @endif">
            <div class="listImage">
                <img class="listImageTag" src="{{asset('images/products/'.$row->image)}}"
                     alt="Изображение {{$row->name}}">
            </div>
            <div class="listName"><a href="{{route('product.show', ['product' => $row])}}">{{$row->name}}</a></div>
            <div class="listCategories">
                @foreach(CategoryProduct::where('product_id', $row->id)->get() as $key => $categoryProduct)
                    {{Category::find($categoryProduct->category_id)->name}}@if(!$loop->last);&nbsp;@endif
                @endforeach
            </div>
            <div class="quantity">@if($row->quantity < 1)Нет в наличии@else{{$row->quantity}}@endif</div>
            <div class="listSellingPrice">{{number_format($row->selling_price, 2)}}₽</div>
            <div class="listManufacturer">{{Manufacturer::find($row->manufacturer_id)->name}}</div>
            <div class="update">
                <form method="GET" action="{{route('product.edit', ['product' => $row])}}">
                    @csrf
                    <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg"
                           alt="Изменить">
                </form>
            </div>
            <div class="delete">
                <form method="POST" action="{{route('product.destroy', ['product' => $row])}}">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg"
                           alt="Удалить">
                </form>
            </div>
        </div>
    @endforeach
@endsection
