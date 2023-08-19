
        <label for="startDate">С</label>
        <input name="startDate" id="startDate" type="date" value="{{ old('startDate', $_GET['startDate'] ?? '') }}">
        <label for="endDate">по</label>
        <input name="endDate" id="endDate" type="date" value="{{ old('endDate', $_GET['endDate'] ?? '') }}">
        <input type="submit" value="Поиск">

