@php
    use \App\Models\OrderProduct;
    use App\Models\Product;
    use App\Models\Payment;
    $fullCost = 0;
    $fullPaymentSum = 0;
@endphp
@extends('layouts.show')
@section('innerHeadShow')
    <link rel="stylesheet" href="{{asset('stylesheets/order.css')}}">
@endsection
@section('mainShow')
    <div class="showWrapper">
{{--        <h1>Заказ {{Client::find($order->client_id)->last_name}} {{Client::find($order->client_id)->first_name}} {{Client::find($order->client_id)->third_name}} от {{$order->date}}</h1>--}}
        <div class="showItem">
            <div class="showOrderDetail">
                <h2>Состав заказа</h2>
                <div class="orderDetailsWrapper">
                    <div class="detailsItem bold">
                        <div class="productName">Название товара</div>
                        <div class="price">Цена</div>
                        <div class="count">Количество</div>
                        <div class="cost">Стоимость</div>
                    </div>
                    @foreach(OrderProduct::where('order_id', $order->id)->get() as $orderProduct)
                        <div class="detailsItem">
                            <div class="productName"><a href="{{route('product.show', ['product' => Product::find($orderProduct->product_id)])}}">{{Product::find($orderProduct->product_id)->name}}</a></div>
                            <div class="price">{{number_format($orderProduct->selling_price, 2)}}₽</div>
                            <div class="count">{{$orderProduct->count}}</div>
                            <div class="cost">{{number_format($orderProduct->selling_price * $orderProduct->count, 2)}}₽</div>
                        </div>
                        @php
                            $fullCost += $orderProduct->selling_price * $orderProduct->count;
                        @endphp
                    @endforeach
                    <div class="detailsItem bold">
                        <div class="fullCost">Общая стоимость</div>
                        <div class="fullCostValue">{{number_format($fullCost, 2)}}₽</div>
                    </div>
                </div>
            </div>
            <div class="showPayments">
                <h2>Платежи</h2>
                <div class="orderPaymentsWrapper">
                    <div class="orderPayment bold">
                        <div class="paymentData">Дата платежа</div>
                        <div class="paymentSum">Сумма платежа</div>
                    </div>
                    @foreach(Payment::where('order_id', $order->id)->get() as $payment)
                        <div class="orderPayment">
                            <div class="paymentData">{{$payment->date}}</div>
                            <div class="paymentSum">{{number_format($payment->amount, 2)}}₽</div>
                        </div>
                        @php
                            $fullPaymentSum += $payment->amount;
                        @endphp
                    @endforeach
                    <div class="orderPayment bold">
                        <div class="paymentData">Общая сумма платежей</div>
                        <div class="paymentSum @if($fullPaymentSum >= $fullCost) green @else mainRed @endif">{{number_format($fullPaymentSum, 2)}}₽</div>
                    </div>
                </div>
                @if($fullPaymentSum < $fullCost)
                <form method="GET" action="{{route('payment.create', ['order' => $order->id])}}">
                    <input type="hidden" name="order" value="{{$order->id}}">
                    <input type="submit" value="Добавить платеж" class="addPayment">
                </form>
                @endif
            </div>
        </div>
        <div class="change">
{{--            <form method="GET" action="{{route('order.edit', ['order' => $order])}}" class="update">--}}
{{--                @csrf--}}
{{--                <input type="submit" value="Изменить">--}}
{{--            </form>--}}
            <form method="POST" action="{{route('order.destroy', ['order' => $order])}}" class="delete">
                @csrf
                @method('DELETE')
                <input type="submit" value="Удалить">
            </form>
        </div>
    </div>
@endsection
