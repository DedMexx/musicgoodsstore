@extends('layouts.form')
@section('innerHeadForm')
    <link rel="stylesheet" href="{{asset('stylesheets/order.css')}}">
@endsection
@section('form')
    <form name="productForm" class="insertForm" method="POST" action="@yield('actionRoute')"
          enctype="multipart/form-data">
        @csrf
        @yield('method')
        <h1 class="formTitle">{{$title}}</h1>
        <div class="inputBlock">
            <label class="insertFormLabel" for="date">Дата:</label>
            <input class="insertFormInput" type="datetime-local" id="date" name="date" value="@yield('date')">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="email">E-mail клиента:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="email" name="email" value="@yield('email')" placeholder="clientmail@example.com">
            <div class="suggest">
                <ul class="autocomplete email"></ul>
            </div>
        </div>
        <h2>Музыкальные товары</h2>
        @yield('products')
        <div class="plusWrapper" id="addProductWrapper">
            <input type="button" class="plus" id="addProduct" value="Добавить товар">
        </div>
        <div>
            <label for="totalCost">Общая стоимость</label>
            <input disabled type="text" class="totalCost" id="totalCost">
        </div>
        <input class="insertFormInput insertFormSubmit" type="submit" value="@yield('buttonText')">
    </form>
@endsection
@section('forScripts')
    <script src="{{asset('scripts/forms/order.js')}}"></script>
@endsection
