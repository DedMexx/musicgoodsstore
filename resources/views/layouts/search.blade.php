<div class="search-wrapper">
    <form action="{{route($tableName.'.index')}}" method="get" class="search">
        <label for="search">Поиск:</label>
        <input id="search" type="search" name="search" class="searchInput" value="{{$query}}" placeholder="@yield('searchPlaceholder')">
        <input type="submit" value="Поиск" class="searchButton">
    </form>
</div>
