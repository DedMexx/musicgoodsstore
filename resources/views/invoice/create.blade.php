@extends('invoice.from')
@section('actionRoute', route('invoice.store'))
@section('number', old('number'))
@section('date', old('date'))
@section('supplier', old('supplier'))
@section('products')
    <div class="inputBlock productBlock">
        <label class="insertFormLabel dynamicInputLabel" for="product_0">
            <input class="autocompleteInput insertFormInput dynamicInputLabelInput" type="text"
                   id="product_0_label" name="product_0_label" placeholder="Yamaha Pacific">
            <div class="suggest">
                <ul class="autocomplete product_0_label"></ul>
            </div>
        </label>
        <input class="autocompleteInput insertFormInput dynamicInput" type="text" id="product_0" name="product_0" placeholder="11">
    </div>
@endsection
@section('buttonText', 'Добавить')
