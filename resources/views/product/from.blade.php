@extends('layouts.form')
@section('innerHeadForm')
    <link rel="stylesheet" href="{{asset('stylesheets/product.css')}}">
@endsection
@section('form')
    <form name="productForm" class="insertForm" method="POST" action="@yield('actionRoute')"
          enctype="multipart/form-data">
        @csrf
        @yield('method')
        <h1 class="formTitle">{{$title}}</h1>
        <div class="inputBlock">
            <label class="insertFormLabel" for="name">Наименование:</label>
            <input class="insertFormInput" type="text" id="name" name="name" value="@yield('name')" placeholder="Yamaha Pacific">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="description">Описание:</label>
            <textarea class="insertFormTextArea" id="description" name="description" placeholder="Описание музыкального товара (не обязательное поле)">@yield('description')</textarea>
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="image">Изображение:</label>
            <input class="insertFormInput" type="file" id="image" name="image" value="@yield('image')"
                   accept="image/jpeg,image/png,image/gif,image/jpg,image/svg">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="purchase_price">Цена покупки:</label>
            <input class="insertFormInput" type="text" id="purchase_price" name="purchase_price"
                   value="@yield('purchase_price')" placeholder="11500.50">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="selling_price">Цена продажи:</label>
            <input class="insertFormInput" type="text" id="selling_price" name="selling_price"
                   value="@yield('selling_price')" placeholder="15499.49">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="warranty">Гарантия:</label>
            <input class="insertFormInput" type="text" id="warranty" name="warranty"
                   value="@yield('warranty')" placeholder="2 года">
        </div>
        <div class="inputBlock">
            <label class="insertFormLabel" for="manufacturer">Производитель:</label>
            <input class="autocompleteInput insertFormInput" type="text" id="manufacturer" name="manufacturer"
                   value="@yield('manufacturer')" placeholder="Yamaha">
            <div class="suggest">
                <ul class="autocomplete manufacturer"></ul>
            </div>
        </div>

        <h2>Характеристики</h2>
        @yield('specifications')
        <div class="plusWrapper" id="addSpecificationWrapper">
            <input type="button" class="plus" id="addSpecification" value="Добавить характеристику">
        </div>
        <h2>Категории</h2>
        @yield('categories')
        <div class="plusWrapper" id="addCategoryWrapper">
            <input type="button" class="plus" id="addCategory" value="Добавить категорию">
        </div>
        <input class="insertFormInput insertFormSubmit" type="submit" value="@yield('buttonText')">
    </form>
    <script src="{{asset('scripts/main.js')}}"></script>
    <script src="{{asset('scripts/forms/product.js')}}"></script>
@endsection
