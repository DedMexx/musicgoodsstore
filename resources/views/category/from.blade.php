@extends('layouts.form')
@section('form')
    <form class="insertForm" method="POST" action="@yield('actionRoute')">
        @csrf
        @yield('method')
        <h1 class="formTitle">{{$title}}</h1>
        <div class="inputBlock">
            <label class="insertFormLabel" for="name">Наименование:</label>
            <input class="insertFormInput autocompleteInput" type="text" id="name" name="name"
                   value="@yield('name')" placeholder="Гитары">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="description">Описание:</label>
            <textarea class="insertFormTextArea" id="description" name="description" placeholder="Описание категории (не обязательное поле)">@yield('description')</textarea>
        </div>
        <input class="insertFormInput insertFormSubmit" type="submit" value="@yield('buttonText')">
    </form>
@endsection
