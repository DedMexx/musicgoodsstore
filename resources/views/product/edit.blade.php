@php
    use App\Models\Manufacturer;
    use App\Models\SpecificationProduct;
    use App\Models\Specification;
    use App\Models\CategoryProduct;
    use App\Models\Category;
@endphp
@extends('product.from')
@section('actionRoute', route('product.update', ['product' => $product]))
@section('method')
    @method('PUT')
@endsection
@section('name', old('name', $product->name))
@section('description', old('description', $product->description))
@section('image', old('image', $product->image))
@section('quantity', old('quantity', $product->quantity))
@section('purchase_price', old('purchase_price', $product->purchase_price))
@section('selling_price', old('selling_price', $product->selling_price))
@section('warranty', old('warranty', $product->warranty))
@section('manufacturer', old('manufacturer', Manufacturer::find($product->manufacturer_id)->name))
@section('specifications')
    @foreach(SpecificationProduct::where('product_id', $product->id)->get() as $key => $specificationProduct)
        <div class="inputBlock specificationBlock">
            <label class="insertFormLabel dynamicInputLabel" for="specification_{{$key}}">
                <input class="autocompleteInput insertFormInput dynamicInputLabelInput" type="text"
                       id="specification_{{$key}}_label" name="specification_{{$key}}_label"
                       value="{{old('specification_'.$key.'_label', Specification::find($specificationProduct->specification_id)->name)}}">
                <div class="suggest"><ul class="autocomplete specification_{{$key}}_label"></ul></div>
            </label>
            <input class="insertFormInput dynamicInput" type="text" id="specification_{{$key}}"
                   name="specification_{{$key}}" value="{{old('specification_'.$key, $specificationProduct->value)}}">
        </div>
    @endforeach
@endsection
@section('categories')
    @foreach(CategoryProduct::where('product_id', $product->id)->get() as $key => $categoryProduct)
        <div class="inputBlock categoryBlock">
            <input class="autocompleteInput insertFormInput categoryInput" type="text" id="category_{{$key}}"
                   name="category_{{$key}}"
                   value="{{old('category_'.$key, Category::find($categoryProduct->category_id)->name)}}">
            <div class="suggest">
                <ul class="autocomplete category_{{$key}}"></ul>
            </div>
        </div>
    @endforeach
@endsection
@section('buttonText', 'Сохранить')
