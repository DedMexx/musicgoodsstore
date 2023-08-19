@extends('payment.from')
@section('actionRoute', route('payment.update', $payment))
@section('method')
    @method('PUT')
@endsection
@section('date', old('date', $payment->date))
@section('amount', old('amount', $payment->amount))
@section('buttonText', 'Сохранить')
