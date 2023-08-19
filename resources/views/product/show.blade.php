@php
    use App\Models\Manufacturer;
    use App\Models\CategoryProduct;
    use App\Models\Category;
    use App\Models\SpecificationProduct;
    use App\Models\Specification;
@endphp
@extends('layouts.show')
@section('innerHeadShow')
    <link rel="stylesheet" href="{{asset('stylesheets/product.css')}}">
@endsection
@section('mainShow')
    <div class="showWrapper">
        <h1>{{ $product->name}}</h1>
        <div class="showItem">
            <div class="showImage">
                <img class="showImage" src="{{asset('images/products/'.$product->image)}}"
                     alt="Изображение {{$product->name}}">
            </div>
            <div class="mainInfo @if(empty($product->description)) noDescription @endif">
                <h2>Основная информация</h2>
                <div>
                    <span>Цена покупки</span>
                    <span>{{number_format($product->purchase_price, 2)}}₽</span>
                </div>
                <div>
                    <span>Цена продажи</span>
                    <span>{{number_format($product->selling_price, 2)}}₽</span>
                </div>
                <div>
                    <span>Гарантия</span>
                    <span>@if(!empty($product->warranty)){{$product->warranty}}@else Отсутствует @endif</span>
                </div>
                <div>
                    <span>Производитель</span>
                    <span>{{Manufacturer::find($product->manufacturer_id)->name}}<div class="hiddenInfoIcon"></div>
                        <div class="hiddenInfoText">
                            {{Manufacturer::find($product->manufacturer_id)->description}}
                        </div></span>
                </div>
                <div>
                    <span>Количество</span>
                    <span>{{$product->quantity}}</span>
                </div>
                <div class="showCategories">
                    Категории:
                    @foreach(CategoryProduct::where('product_id', $product->id)->get() as $key => $categoryProduct)
                        {{Category::find($categoryProduct->category_id)->name}}@if(Category::find($categoryProduct->category_id)->description)<div class="hiddenInfoIcon">
                        </div>
                        <div class="hiddenInfoText">
                            {{Category::find($categoryProduct->category_id)->description}}
                        </div>
                    @endif
                        @if(!$loop->last),&nbsp;@endif
                    @endforeach
                </div>
                <h3>Характеристики:</h3>
                @foreach(SpecificationProduct::where('product_id', $product->id)->get() as $specificationProduct)
                    <div>
                        <span>{{Specification::find($specificationProduct->specification_id)->name}}</span>
                        @if(Specification::find($specificationProduct->specification_id)->description)
                        <div class="hiddenInfoIcon">
                        </div>
                        <div class="hiddenInfoText">
                            {{Specification::find($specificationProduct->specification_id)->description}}
                        </div>
                        @endif
                        <span>{{$specificationProduct->value}}</span>
                    </div>
                @endforeach
            </div>
            @if(!empty($product->description))
            <div class="showDescription">
                <h2>Описание</h2>
                <div class="descriptionText">
                    {{$product->description}}
                </div>
            </div>
            @endif
        </div>
        <div class="change">
            <form method="GET" action="{{route('product.edit', ['product' => $product])}}" class="update">
                @csrf
                <input type="submit" value="Изменить">
            </form>
            <form method="POST" action="{{route('product.destroy', ['product' => $product])}}" class="delete">
                @csrf
                @method('DELETE')
                <input type="submit" value="Удалить">
            </form>
        </div>
    </div>
@endsection
