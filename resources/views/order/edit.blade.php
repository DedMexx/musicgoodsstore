@php
    use App\Models\Client;
    use App\Models\OrderProduct;
    use App\Models\Product;
@endphp
@extends('order.from')
@section('actionRoute', route('order.update', ['order' => $order]))
@section('method')
    @method('PUT')
@endsection
@section('date', old('date', $order->date))
@section('email', old('email', Client::find($order->client_id)->email))
@section('products')
    @foreach(OrderProduct::where('order_id', $order->id)->get() as $key => $orderProduct)
        @if($key === 0)
            <div class="inputBlock productBlock">
                <div><label for="product_{{$key}}">Название товара</label><input
                        class="autocompleteInput insertFormInput dynamicInput productName" type="text"
                        id="product_{{$key}}" name="product_{{$key}}" placeholder="Yamaha Pacific"
                        value="{{old('product_'.$key, Product::find($orderProduct->product_id)->name)}}"></div>
                <div class="suggest">
                    <ul class="autocomplete product_{{$key}}"></ul>
                </div>
                <div><label for="product_{{$key}}_amount">Количество</label><input
                        class="insertFormInput dynamicInput amount"
                        type="text" id="product_{{$key}}_amount" name="product_{{$key}}_amount" placeholder="2"
                        value="{{old('product_'.$key.'_amount', $orderProduct->count)}}"></div>
                <div><label for="product_{{$key}}_price">Цена</label><input disabled
                        class="insertFormInput dynamicInput" type="text" id="product_{{$key}}_price"
                        name="product_{{$key}}_price" placeholder="15,000.50₽"></div>
                <div><label for="product_{{$key}}_cost">Стоимость</label><input disabled
                        class="insertFormInput dynamicInput cost" type="text" id="product_{{$key}}_cost"
                        name="product_{{$key}}_cost" placeholder="30,001.00₽"></div>
            </div>
        @else
            <div class="inputBlock productBlock">
                <input
                    class="autocompleteInput insertFormInput dynamicInput productName" type="text"
                    id="product_{{$key}}" name="product_{{$key}}" placeholder="Yamaha Pacific"
                    value="{{old('product_'.$key, Product::find($orderProduct->product_id)->name)}}">
                <div class="suggest">
                    <ul class="autocomplete product_{{$key}}"></ul>
                </div>
                <input class="insertFormInput dynamicInput amount"
                       type="text" id="product_{{$key}}_amount" name="product_{{$key}}_amount" placeholder="2"
                       value="{{old('product_'.$key.'_amount', $orderProduct->count)}}">
                <input disabled class="insertFormInput dynamicInput"
                       type="text" id="product_{{$key}}_price" name="product_{{$key}}_price" placeholder="15,000.50₽">
                <input disabled class="insertFormInput dynamicInput cost" type="text" id="product_{{$key}}_cost"
                       name="product_{{$key}}_cost"
                       placeholder="30,001.00₽">
            </div>
        @endif
    @endforeach
@endsection
@section('buttonText', 'Сохранить')
