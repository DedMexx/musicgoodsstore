@extends('layouts.list')
@section('innerHeadList')
    <link rel="stylesheet" href="{{asset('stylesheets/manufacturer.css')}}">
@endsection
@section('searchPlaceholder', 'Название производителя')
@section('add', 'нового производителя')
@section('list')
    <div class="listHeader">
        <div class="listCheckProducts">Посмотреть товары</div>
        <div class="listName">Название</div>
        <div class="listDescription">Описание</div>
        <div class="listAddress">Адрес</div>
        <div class="listPostIndex">Почт. индекс</div>
        <div class="update">Изменить</div>
        <div class="delete">Удалить</div>
    </div>
    @foreach($table as $row)
        <div class="item">
            <div class="listCheckProducts"><a href="{{route('product.index', ['search' => $row->name])}}">Перейти к товарам</a></div>
            <div class="listName">{{$row->name}}</div>
            <div class="listDescription">@if($row->description){{$row->description}}@elseОписание
                отсутствует@endif</div>
            <div class="listAddress">
                @if($row->country || $row->region || $row->city || $row->street)
                    <a target="_blank"
                       href="https://yandex.ru/maps/?mode=search&text=@isset($row->country){{$row->country}},@endif @isset($row->region){{$row->region}},@endif @isset($row->city){{$row->city}},@endif @isset($row->street){{$row->street}},@endif @isset($row->house){{$row->house}}@endif">
                        @isset($row->country){{$row->country}}@if($row->region || $row->city || $row->street || $row->house),@endif @endif
                        @isset($row->region){{$row->region}}@if($row->city || $row->street || $row->house),@endif @endif
                        @isset($row->city){{$row->city}}@if($row->street || $row->house),@endif @endif
                        @isset($row->street){{$row->street}}@if($row->house),@endif @endif
                        @isset($row->house){{$row->house}}@endif
                    </a>
                @else
                    Адрес не указан
                @endif
            </div>

            <div class="listPostIndex">@if($row->post_index){{$row->post_index}}@elseНе указан@endif</div>
            <div class="update">
                <form method="GET" action="{{route('manufacturer.edit', ['manufacturer' => $row])}}">
                    @csrf
                    <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg" alt="Изменить">
                </form>
            </div>
            <div class="delete">
                <form method="POST" action="{{route('manufacturer.destroy', ['manufacturer' => $row])}}">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg" alt="Удалить">
                </form>
            </div>
        </div>
    @endforeach
@endsection
