@extends('layouts.form')
@section('innerHeadForm')
    <link rel="stylesheet" href="{{asset('stylesheets/invoice.css')}}">
@endsection
@section('form')
    <form class="insertForm" method="POST" action="@yield('actionRoute')">
        @csrf
        @yield('method')
        <h1 class="formTitle">{{$title}}</h1>
        <div class="inputBlock">
            <label class="insertFormLabel" for="number">Номер:</label>
            <input class="insertFormInput" type="text" id="number" name="number" value="@yield('number')" placeholder="141245232">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="date">Дата:</label>
            <input class="autocompleteInput insertFormInput" type="datetime-local" id="date" name="date" value="@yield('date')">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="supplier">Поставщик:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="supplier" name="supplier" value="@yield('supplier')" placeholder="АзбукаЗвука">
            <div class="suggest">
                <ul class="autocomplete supplier"></ul>
            </div>
        </div>
        <h2>Товары</h2>
        @yield('products')
        <div class="plusWrapper" id="addProductWrapper">
            <input type="button" class="plus" id="addProduct" value="Добавить товар">
        </div>
        <input class="insertFormInput insertFormSubmit" type="submit" value="@yield('buttonText')">
    </form>
    <script src="{{asset('scripts/main.js')}}"></script>
    <script src="{{asset('scripts/forms/invoice.js')}}"></script>
@endsection
