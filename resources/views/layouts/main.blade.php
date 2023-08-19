<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') – MGS IS</title>
    <link rel="stylesheet" href="{{asset('stylesheets/main.css')}}">
    <link rel="icon" href="{{asset('images/technical/logo_piano_whiteBG.png')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('innerHead')
</head>
<body>
<div class="wrapper">
    <header>
        <div class="header-wrapper">
            <img src="{{asset('images/technical/logo.png')}}" class="logo" alt="Логотип компании MGS IS">
            <nav>
                <div class="dropdown-wrapper">
                <a class="references @yield('references')">
                    <img class="arrow" src="{{asset('images/technical/arrow.png')}}" alt="">
                    <span>Справочники</span>
                </a>
                <div class="dropdown-content">
                    <a class="@yield('category')" href="{{route('category.index')}}">Категории</a>
                    <a class="@yield('specification')" href="{{route('specification.index')}}">Характеристики</a>
                    <a class="@yield('supplier')" href="{{route('supplier.index')}}">Поставщики</a>
                    <a class="@yield('manufacturer')" href="{{route('manufacturer.index')}}">Производители</a>
                    <a class="@yield('product')" href="{{route('product.index')}}">Музыкальные товары</a>
                </div>
                </div>
                <a class="@yield('invoice')" href="{{route('invoice.index')}}">Накладные</a>
                <a class="@yield('order')" href="{{route('order.index')}}">Заказы</a>
                <a class="@yield('payment')" href="{{route('payment.index')}}">Платежи</a>
                <a class="@yield('client')" href="{{route('client.index')}}">Клиенты</a>
                <div class="dropdown-wrapper">
                    <a class="reports @yield('report')">
                        <img class="arrow" src="{{asset('images/technical/arrow.png')}}" alt="">
                        <span>Отчеты</span>
                    </a>
                        <div class="dropdown-content">
                            <div class="dropdown-wrapper">
                                <a class="forSelling @yield('sales')">
                                    <span>Продажи</span>
                                    <img class="arrow " src="{{asset('images/technical/arrow.png')}}" alt="">
                                </a>
                                <div class="dropdown-content">
                                    <a class="@yield('salesByCategory')" href="{{route('report.salesByCategory')}}">По категориям</a>
                                    <a class="@yield('salesByManufacturer')"  href="{{route('report.salesByManufacturer')}}">По производителям</a>
                                    <a class="@yield('salesByPeriod')"  href="{{route('report.salesByPeriod')}}">За период</a>
                                </div>
                            </div>
{{--                            <a class="@yield('inventory')"  href="{{route('report.inventory')}}">Наличие товаров</a>--}}
{{--                            <a class="@yield('customerOrders')"  href="{{route('report.customerOrders')}}">Заказы клиентов</a>--}}
{{--                            <a class="@yield('supplies')"  href="{{route('report.supplies')}}">Поставки</a>--}}
                            <a class="@yield('tbr')"  href="{{route('report.tbr')}}">Оборотно-сальдовая ведомость</a>
                            <a class="@yield('profit')"  href="{{route('report.profit')}}">Прибыль</a>
                        </div>
                </div>

            </nav>
        </div>
    </header>
    <main>
        <div class="content-wrapper">
            @yield('main')
        </div>
    </main>
    <footer>
        <div class="footer-wrapper">
            <div class="copyrighting">MusicGoodsStore Information System © {{date('Y')}}</div>
        </div>
    </footer>
</div>
</body>
</html>
