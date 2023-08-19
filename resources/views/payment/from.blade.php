@extends('layouts.form')
@section('innerHeadForm')
    <link rel="stylesheet" href="{{asset('stylesheets/payment.css')}}">
@endsection
@section('form')
    <form name="paymentForm" class="insertForm" method="POST" action="@yield('actionRoute')"
          enctype="multipart/form-data">
        @csrf
        @yield('method')
        @yield('orderId')
        <h1 class="formTitle">{{$title}}</h1>
        <div class="inputBlock">
            <label class="insertFormLabel" for="date">Дата:</label>
            <input class="insertFormInput" type="datetime-local" id="date" name="date" value="@yield('date')">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="amount">Сумма:</label>
            <input class="insertFormInput" type="text" id="amount" name="amount" value="@yield('amount')" placeholder="9,499.99₽">
        </div>
        <input class="insertFormInput insertFormSubmit" type="submit" value="@yield('buttonText')">
    </form>
    <script src="{{asset('scripts/main.js')}}"></script>
    <script src="{{asset('scripts/forms/payment.js')}}"></script>
@endsection
