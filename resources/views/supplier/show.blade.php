@extends('layouts.show')
@section('main')
    <div class="showWrapper">
        <h1>{{$supplier->name}}</h1>
        <div class="showItem">
            <div>
                <h2>Контактные данные</h2>
                <div class="mainInfo">
                    <div class="showEmail">
                        <span>E-mail</span>
                        <span><a href="mailto:{{$supplier->email}}">{{$supplier->email}}</a></span>
                    </div>
                    <div class="showPhone">
                        <span>Номер телефна</span>
                        <span><a href="tel:{{$supplier->phone}}">{{$supplier->phone}}</a></span>
                    </div>
                    <div class="showFIO">
                        <span>ФИО отвественного</span>
                        <span>{{$supplier->last_name}}  {{$supplier->first_name}} {{$supplier->third_name}}</span>
                    </div>
                </div>
            </div>
            <div class="showAddress">
                <h2>
                    <a href="https://yandex.ru/maps/?mode=search&text={{$supplier->country}} {{$supplier->region}} {{$supplier->city}} {{$supplier->street}} {{$supplier->house}}" target="_blank">Адрес</a></h2>
                <div class="addressInfo">
                    <div>
                        <span>Страна</span>
                        <span>{{$supplier->country}}</span>
                    </div>
                    <div>
                        <span>Регион</span>
                        <span>{{$supplier->region}}</span>
                    </div>
                    <div>
                        <span>Город</span>
                        <span>{{$supplier->city}}</span>
                    </div>
                    <div>
                        <span>Адрес</span>
                        <span>{{$supplier->street}}, {{$supplier->house}}</span>
                    </div>
                    <div>
                        <span>Почтовый индекс</span>
                        <span>{{$supplier->post_index}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="change">
            <form method="GET" action="{{route('supplier.edit', ['supplier' => $supplier])}}" class="update">
                @csrf
                <input type="submit" value="Изменить">
            </form>
            <form method="POST" action="{{route('supplier.destroy', ['supplier' => $supplier])}}" class="delete">
                @csrf
                @method('DELETE')
                <input type="submit" value="Удалить">
            </form>
        </div>
    </div>
@endsection
