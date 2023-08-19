@extends('order.from')
@section('actionRoute', route('order.store'))
@section('date', old('date'))
@section('email', old('email'))
@section('products')
    <div class="inputBlock productBlock">
        <div><label for="product_0">Название товара</label><input
                class="autocompleteInput insertFormInput dynamicInput productName" type="text"
                id="product_0" name="product_0" placeholder="Yamaha Pacific"></div>
        <div class="suggest">
            <ul class="autocomplete product_0"></ul>
        </div>
        <div><label for="product_0_amount">Количество</label><input class="insertFormInput dynamicInput amount" type="text"
                                                          id="product_0_amount" name="product_0_amount"
                                                          placeholder="2"></div>
        <div><label for="product_0_price">Цена</label><input disabled class="insertFormInput dynamicInput" type="text" id="product_0_price" name="product_0_price"
                                                         placeholder="15,000.50₽"></div>
        <div><label for="product_0_cost">Стоимость</label><input disabled class="insertFormInput dynamicInput cost" type="text" id="product_0_cost" name="product_0_cost"
                                                        placeholder="30,001.00₽"></div>
    </div>
@endsection
@section('buttonText', 'Добавить')
