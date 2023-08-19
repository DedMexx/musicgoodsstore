@php
    use App\Models\Supplier;
    use App\Models\InvoiceProduct;
    use App\Models\Product;
@endphp
@extends('layouts.list')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/invoice.css')}}">
@endsection
@section('searchPlaceholder', 'Номер, дата или название поставщика')
@section('add', 'новую накладную')
@section('list')
    <div class="listHeader">
        <div class="listNumber">Номер</div>
        <div class="listDate">Дата</div>
        <div class="listSupplier">Поставщик</div>
        <div class="listProducts">Товары</div>
        <div class="listQuantity">Количество</div>
        <div class="update">Изменить</div>
        <div class="delete">Удалить</div>
    </div>
    @foreach($table as $row)
        <div class="item">
{{--            <div class="listCheckProducts"><a href="">Перейти к товарам</a></div>--}}
            <div class="listNumber">{{$row->number}}</div>
            <div class="listDate">{{$row->date}}</div>
            <div class="listSupplier"><a href="{{route('supplier.show', ['supplier' => Supplier::find($row->supplier_id)])}}">{{Supplier::find($row->supplier_id)->name}}</a></div>
            <div class="listProducts">
                @foreach(InvoiceProduct::where('invoice_id', $row->id)->get() as $invoiceItem)
                    <div class="listProductItemName"><a href="{{route('product.show', ['product' => Product::find($invoiceItem->product_id)])}}">{{Product::find($invoiceItem->product_id)->name}}</a></div>
                @endforeach
            </div>
            <div class="listQuantity">
                @foreach(InvoiceProduct::where('invoice_id', $row->id)->get() as $invoiceItem)
                    <div class="listProductItemQuantity">{{$invoiceItem->quantity}}</div>
                @endforeach
            </div>
            <div class="update">
                <form method="GET" action="{{route('invoice.edit', ['invoice' => $row])}}">
                    @csrf
                    <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg" alt="Изменить">
                </form>
            </div>
            <div class="delete">
                <form method="POST" action="{{route('invoice.destroy', ['invoice' => $row])}}">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg" alt="Удалить">
                </form>
            </div>
        </div>
    @endforeach
@endsection
@section('innerFooter')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var maxItemHeight = Math.max($('.listProductItemName').height(), $('.listProductItemQuantity').height());
            $('.listProductItemName, .listProductItemQuantity').height(maxItemHeight);
        });
    </script>
@endsection
