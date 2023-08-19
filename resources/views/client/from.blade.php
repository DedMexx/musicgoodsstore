@extends('layouts.form')
@section('innerHeadForm')
    <link rel="stylesheet" href="{{asset('stylesheets/supplier.css')}}">
@endsection
@section('form')
    <form name="supplierForm" class="insertForm" method="POST" action="@yield('actionRoute')">
        @csrf
        @yield('method')
        <h1 class="formTitle">{{$title}}</h1>
        <div class="inputBlock">
            <label class="insertFormLabel" for="last_name">Фамилия:</label>
            <input class="insertFormInput" type="text" id="last_name" name="last_name"
                   value="@yield('last_name')" placeholder="Петров">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="first_name">Имя:</label>
            <input class="insertFormInput" type="text" id="first_name" name="first_name"
                   value="@yield('first_name')" placeholder="Виктор">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="third_name">Отчество:</label>
            <input class="insertFormInput" type="text" id="third_name" name="third_name"
                   value="@yield('third_name')" placeholder="Семенович">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="email">E-mail:</label>
            <input class="insertFormInput" type="email" id="email" name="email" value="@yield('email')" placeholder="petrov.vs@example.com">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="phone">Телефон:</label>
            <input class="insertFormInput" type="text" id="phone" name="phone" value="@yield('phone')" placeholder="+7(999)999-99-99">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="country">Страна:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="country" name="country" placeholder="Россия"
                   value="@yield('country')">
            <div class="suggest">
                <ul class="autocomplete country"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="region">Регион:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="region" name="region" placeholder="Тюменская обл."
                   value="@yield('region')">
            <div class="suggest">
                <ul class="autocomplete region"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="city">Город:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="city" name="city" value="@yield('city')" placeholder="Тюмень">
            <div class="suggest">
                <ul class="autocomplete city"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="street">Улица:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="street" name="street" placeholder="ул. Республики"
                   value="@yield('street')">
            <div class="suggest">
                <ul class="autocomplete street"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="house">Дом:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="house" name="house" placeholder="138А"
                   value="@yield('house')">
            <div class="suggest">
                <ul class="autocomplete house"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="post_index">Почтовый индекс:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="post_index" name="post_index" placeholder="625015"
                   value="@yield('post_index')">
            <div class="suggest">
                <ul class="autocomplete post_index"></ul>
            </div>
        </div>
        <input class="insertFormInput insertFormSubmit" type="submit" value="@yield('buttonText')">
    </form>
    <script src="{{asset('scripts/main.js')}}"></script>
@endsection
