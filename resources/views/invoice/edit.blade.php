@php
    use App\Models\Supplier;
    use App\Models\InvoiceProduct;
    use App\Models\Product;
@endphp
@extends('invoice.from')
@section('actionRoute', route('invoice.update', ['invoice' => $invoice]))
@section('method')
    @method('PUT')
@endsection
@section('number', old('number', $invoice->number))
@section('date', old('date', $invoice->date))
@section('supplier', old('supplier', Supplier::find($invoice->supplier_id)->name))
@section('products')
    @foreach(InvoiceProduct::where('invoice_id', $invoice->id)->get() as $key => $invoiceProduct)
        <div class="inputBlock productBlock">
            <label class="insertFormLabel dynamicInputLabel" for="product_{{$key}}">
                <input class="autocompleteInput insertFormInput dynamicInputLabelInput" type="text"
                       id="product_{{$key}}_label" name="product_{{$key}}_label"
                       value="{{old('product_'.$key.'_label',Product::find($invoiceProduct->product_id)->name)}}">
                <div class="suggest">
                    <ul class="autocomplete product_{{$key}}_label"></ul>
                </div>
            </label>
            <input class="autocompleteInput insertFormInput dynamicInput" type="text" id="product_{{$key}}"
                   name="product_{{$key}}" value="{{old('product_'.$key, $invoiceProduct->quantity)}}">
        </div>
    @endforeach
@endsection
@section('buttonText', 'Сохранить')
