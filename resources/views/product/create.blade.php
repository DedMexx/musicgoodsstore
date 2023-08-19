@extends('product.from')
@section('actionRoute', route('product.store'))
@section('name', old('name'))
@section('description', old('description'))
@section('image', old('image'))
@section('quantity', old('quantity'))
@section('purchase_price', old('purchase_price'))
@section('selling_price', old('selling_price'))
@section('warranty', old('warranty'))
@section('manufacturer', old('manufacturer'))
@section('specifications')
        <div class="inputBlock specificationBlock">
            <label class="insertFormLabel dynamicInputLabel" for="specification_0">
                <input class="autocompleteInput insertFormInput dynamicInputLabelInput" type="text"
                       id="specification_0_label" name="specification_0_label" placeholder="Количество струн"
                       value="{{old('specification_0_label')}}">
                <div class="suggest"><ul class="autocomplete specification_0_label"></ul></div>
            </label>
            <input class="insertFormInput dynamicInput" type="text" id="specification_0" name="specification_0"
                   placeholder="6" value="{{old('specification_0')}}">
        </div>
@endsection
@section('categories')
        <div class="inputBlock categoryBlock">
            <input class="autocompleteInput insertFormInput categoryInput" type="text" id="category_0"
                   name="category_0" placeholder="Гитары" value="{{old('category_0')}}">
            <div class="suggest">
                <ul class="autocomplete category_0"></ul>
            </div>
        </div>
@endsection
@section('buttonText', 'Добавить')
