@extends('layouts.show')
@section('mainShow')
    <div class="showWrapper">
        <h1>{{$client->last_name}} {{$client->first_name}} {{$client->third_name}}</h1>
        <div class="showItem">
            <div>
                <h2>Контактные данные</h2>
                <div class="mainInfo">
                    <div class="showEmail">
                        <span>E-mail</span>
                        <span><a href="mailto:{{$client->email}}">{{$client->email}}</a></span>
                    </div>
                    <div class="showPhone">
                        <span>Номер телефна</span>
                        <span><a href="tel:{{$client->phone}}">{{$client->phone}}</a></span>
                    </div>
                </div>
            </div>
            <div>
                <h2>
                    <a href="https://yandex.ru/maps/?mode=search&text={{$client->country}} {{$client->region}} {{$client->city}} {{$client->street}} {{$client->house}}"
                       target="_blank">Адрес</a>
                </h2>
                <div class="addressInfo">
                    <div>
                        <span>Страна</span>
                        <span>{{$client->country}}</span>
                    </div>
                    <div>
                        <span>Регион</span>
                        <span>{{$client->region}}</span>
                    </div>
                    <div>
                        <span>Город</span>
                        <span>{{$client->city}}</span>
                    </div>
                    <div>
                        <span>Адрес</span>
                        <span>{{$client->street}}, {{$client->house}}</span>
                    </div>
                    <div>
                        <span>Почтовый индекс</span>
                        <span>{{$client->post_index}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="change">
            <form method="GET" action="{{route('client.edit', ['client' => $client])}}" class="update">
                @csrf
                <input type="submit" value="Изменить">
            </form>
            <form method="POST" action="{{route('client.destroy', ['client' => $client])}}" class="delete">
                @csrf
                @method('DELETE')
                <input type="submit" value="Удалить">
            </form>
        </div>
    </div>
@endsection
