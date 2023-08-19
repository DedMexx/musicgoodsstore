@extends('layouts.form')
@section('form')
    <form id="manufacturer" class="insertForm" method="POST" action="@yield('actionRoute')">
        @csrf
        @yield('method')
        <h1 class="formTitle">{{$title}}</h1>
        <div class="inputBlock">
            <label class="insertFormLabel" for="name">Наименование:</label>
            <input class="insertFormInput" type="text" id="name" name="name" value="@yield('name')" placeholder="СОЮЗ">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="description">Описание:</label>
            <textarea class="insertFormTextArea" id="description" name="description" placeholder="Описание производителя (не обязательное поле)">@yield('description')</textarea>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="country">Страна:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="country" name="country" value="@yield('country')" placeholder="Россия">
            <div class="suggest">
                <ul class="autocomplete country"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="region">Регион:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="region" name="region" value="@yield('region')" placeholder="Московская обл.">
            <div class="suggest">
                <ul class="autocomplete region"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="city">Город:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="city" name="city" value="@yield('city')" placeholder="Москва">
            <div class="suggest">
                <ul class="autocomplete city"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="street">Улица:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="street" name="street" value="@yield('street')" placeholder="ул. Ленина">
            <div class="suggest">
                <ul class="autocomplete street"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="house">Дом:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="house" name="house" value="@yield('house')" placeholder="21/1">
            <div class="suggest">
                <ul class="autocomplete house"></ul>
            </div>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="post_index">Почтовый индекс:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="post_index" name="post_index" value="@yield('post_index')" placeholder="625023">
            <div class="suggest">
                <ul class="autocomplete post_index"></ul>
            </div>
        </div>
        <input class="insertFormInput insertFormSubmit" type="submit" value="@yield('buttonText')">
    </form>
    <script src="{{asset('scripts/main.js')}}"></script>
@endsection
