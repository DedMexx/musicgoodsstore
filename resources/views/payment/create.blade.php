@extends('payment.from')
@section('actionRoute', route('payment.store', $order))
@section('orderId')
    <input type="hidden" name="order" value="{{$order}}">
@endsection
@section('date', old('date'))
@section('amount', old('amount'))
@section('buttonText', 'Добавить')
