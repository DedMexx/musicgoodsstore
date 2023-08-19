@extends('layouts.list')
@section('add', 'новую категорию')
@section('searchPlaceholder', 'Название категории')
@section('list')
        <div class="listHeader">
            <div class="listName">Название</div>
            <div class="listDescription">Описание</div>
            <div class="update">Изменить</div>
            <div class="delete">Удалить</div>
        </div>
        @foreach($table as $row)
            <div class="item">
                <div class="listName">{{$row->name}}</div>
                <div class="listDescription">{{$row->description}}</div>
                <div class="update">
                    <form method="GET" action="{{route('category.edit', ['category' => $row])}}">
                        @csrf
                        <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg" alt="Изменить">
                    </form>
                </div>
                <div class="delete">
                    <form method="POST" action="{{route('category.destroy', ['category' => $row])}}">
                        @csrf
                        @method('DELETE')
                        <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg" alt="Удалить">
                    </form>
                </div>
            </div>
        @endforeach
@endsection
