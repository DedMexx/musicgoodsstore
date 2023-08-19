@php
    use App\Models\Order;
    use App\Models\Client;
@endphp
@extends($tableName.'.main')
@section('innerHead')
    <link rel="stylesheet" href="{{asset('stylesheets/list.css')}}">
    <link rel="stylesheet" href="{{asset('stylesheets/payment.css')}}">
@endsection
@section('main')
    <h1 class="listTitle">{{$title}}</h1>
    <div class="search-wrapper">
        <form action="{{route($tableName.'.index')}}" method="get" class="search">
            <label for="search">Поиск:</label>
            <input id="search" type="search" name="search" class="searchInput" value="{{$query}}" placeholder="ФИО клиента, E-mail, телефон или дата">
            <input type="submit" value="Поиск" class="searchButton">
        </form>
    </div>
    @if (!$table->isEmpty())
        <div class="list">
            <div class="listHeader">
                <div class="listShowOrder"></div>
                <div class="listDate">Дата платежа</div>
                <div class="listAmount">Сумма платежа</div>
                <div class="listClient">Клиент</div>
                <div class="update">Изменить</div>
                <div class="delete">Удалить</div>
            </div>
            @foreach($table as $row)
                <div class="item">
                    <div class="listShowOrder">
                        <a href="{{route('order.show', ['order'=>Order::find($row->order_id)])}}">Перейти к заказу</a>
                    </div>
                    <div class="listDate">{{$row->date}}</div>
                    <div class="listAmount">{{number_format($row->amount, 2)}}₽</div>
                    <div class="listClient">
                        <a href="{{route('client.show', ['client' => Client::find(Order::find($row->order_id)->client_id)])}}">
                            {{Client::find(Order::find($row->order_id)->client_id)->last_name}} {{Client::find(Order::find($row->order_id)->client_id)->first_name}} {{Client::find(Order::find($row->order_id)->client_id)->third_name}}
                        </a>
                        <a href="mailto:{{Client::find(Order::find($row->order_id)->client_id)->email}}">
                            {{Client::find(Order::find($row->order_id)->client_id)->email}}
                        </a>
                        <a href="tel:{{Client::find(Order::find($row->order_id)->client_id)->phone}}">
                            {{Client::find(Order::find($row->order_id)->client_id)->phone}}
                        </a>
                    </div>
                    <div class="update">
                        <form method="GET" action="{{route('payment.edit', ['payment' => $row])}}">
                            @csrf
                            <input type="image" src="{{asset('images/technical/edit.png')}}" class="editImg"
                                   alt="Изменить">
                        </form>
                    </div>
                    <div class="delete">
                        <form method="POST" action="{{route('payment.destroy', ['payment' => $row])}}">
                            @csrf
                            @method('DELETE')
                            <input type="image" src="{{asset('images/technical/delete.png')}}" class="deleteImg"
                                   alt="Удалить">
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        {{$table->links()}}
    @else
        <div class="searchNotFound">
            По запросу ничего не удалось найти
        </div>
    @endif
    <script src="{{asset('scripts/lists/list.js')}}"></script>
@endsection
