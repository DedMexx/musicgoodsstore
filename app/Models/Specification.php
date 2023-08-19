<?php

namespace App\Models;

use App\Http\Controllers\MainController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $table = 'specifications';
    protected $guarded = ['id'];

    static public function search($query) {
        return Specification::select()
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orderBy('name', 'ASC');
    }

    static public function storeOrUpdate($request, $specification = null)
    {
        if (is_null($specification)) {
            $specification = new Specification;
        }
        $specification->name = MainController::capitalizeFirstWord($request->name);
        $specification->description = $request->description;
        $specification->save();
    }

    static public function makeDefault()
    {

        $spec = new Specification;
        $spec->name = 'Динамический диапазон';
        $spec->description = 'Разница между наибольшим и наименьшим значением уровня звукового давления, которое может обработать аппаратура без существенного увеличения искажений';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Частотный диапазон';
        $spec->description = 'Диапазон частот, в пределах которого работает аппаратура';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Сопротивление';
        $spec->description = 'Сопротивление, которое представляет из себя нагрузку на выходное устройство';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Максимальная мощность';
        $spec->description = 'Максимальная мощность, которую может обрабатывать аппаратура без существенного увеличения искажений';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Чувствительность';
        $spec->description = 'Отношение уровня звукового давления на выходе аппаратуры к уровню напряжения на ее входе при определенной частоте';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Коэффициент гармоник';
        $spec->description = 'Отношение мощности гармоник к мощности основной составляющей сигнала';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Диаметр динамика';
        $spec->description = 'Диаметр мембраны динамика, измеряемый в миллиметрах';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Сопротивление микрофона';
        $spec->description = 'Сопротивление микрофона, которое представляет из себя нагрузку на усилитель';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Чувствительность микрофона';
        $spec->description = 'Отношение уровня выходного сигнала микрофона к уровню звукового давления на его диафрагме при определенной частоте';
        $spec->save();

        $spec1 = new Specification;
        $spec1->name = 'Амплитудно-частотная характеристика (АЧХ)';
        $spec1->description = 'Отображает, как частота влияет на амплитуду звука, то есть как громко или тихо звучит звук в зависимости от его частоты. Это особенно важно для колонок и наушников, чтобы понимать, насколько точно они воспроизводят звук в разных частотных диапазонах. Измеряется в герцах (Гц) и децибелах (дБ).';
        $spec1->save();

        $spec2 = new Specification;
        $spec2->name = 'Габаритные размеры';
        $spec2->description = 'Габаритные размеры инструмента или оборудования, выраженные в миллиметрах (мм) или дюймах (дюйм). Это позволяет оценить, насколько удобно будет использовать или хранить товар.';
        $spec2->save();

        $spec3 = new Specification;
        $spec3->name = 'Вес';
        $spec3->description = 'Вес инструмента или оборудования, выраженный в килограммах (кг) или фунтах (фт). Это позволяет оценить, насколько удобно будет переносить или использовать товар.';
        $spec3->save();

        $spec4 = new Specification;
        $spec4->name = 'Материал корпуса';
        $spec4->description = 'Материал, из которого сделан корпус колонок или наушников. Обычно это пластик, металл, дерево или комбинация этих материалов. Это может влиять на качество звука, прочность и внешний вид товара.';
        $spec4->save();

        $spec5 = new Specification;
        $spec5->name = 'Диаметр динамиков';
        $spec5->description = 'Диаметр динамиков в колонках или наушниках, выраженный в миллиметрах (мм) или дюймах (дюйм). Это позволяет оценить, насколько точно товар воспроизводит звук, а также какой уровень громкости и баса можно ожидать.';
        $spec5->save();

        $spec = new Specification;
        $spec->name = 'Тип соединения';
        $spec->description = 'Описание типа соединения музыкального инструмента или устройства';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Количество октав';
        $spec->description = 'Количество октав в пианино или MIDI-клавиатуре';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Тип гитарных струн';
        $spec->description = 'Описание типа гитарных струн (например, стальные, нейлоновые)';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Тип звукоснимателя';
        $spec->description = 'Описание типа звукоснимателя гитары';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Тип микрофона';
        $spec->description = 'Описание типа микрофона (динамический, конденсаторный и т.д.)';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Количество динамиков';
        $spec->description = 'Количество динамиков в акустической системе или наушниках';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Тип наушников';
        $spec->description = 'Описание типа наушников (открытые, закрытые, вставные)';
        $spec->save();

        $spec = new Specification;
        $spec->name = 'Диапазон частот';
        $spec->description = 'Диапазон воспроизводимых частот в колонках или наушниках';
        $spec->save();

        $color = new Specification;
        $color->name = 'Цвет';
        $color->description = 'Цвет товара или его корпуса.';
        $color->save();

        $powerConsumption = new Specification;
        $powerConsumption->name = 'Потребляемая мощность';
        $powerConsumption->description = 'Мощность, потребляемая устройством при его работе.';
        $powerConsumption->save();

        $displaySize = new Specification;
        $displaySize->name = 'Размер дисплея';
        $displaySize->description = 'Размер дисплея устройства, выраженный в дюймах.';
        $displaySize->save();

        $batteryLife = new Specification;
        $batteryLife->name = 'Время работы от аккумулятора';
        $batteryLife->description = 'Продолжительность работы устройства от полностью заряженного аккумулятора.';
        $batteryLife->save();

        $connectivity = new Specification;
        $connectivity->name = 'Возможности подключения';
        $connectivity->description = 'Описание возможностей подключения устройства (например, Bluetooth, Wi-Fi, USB).';
        $connectivity->save();

        $storageCapacity = new Specification;
        $storageCapacity->name = 'Емкость памяти';
        $storageCapacity->description = 'Емкость памяти устройства, выраженная в гигабайтах (ГБ) или терабайтах (ТБ).';
        $storageCapacity->save();

        $processor = new Specification;
        $processor->name = 'Тип процессора';
        $processor->description = 'Описание типа процессора, используемого в устройстве.';
        $processor->save();

        $resolution = new Specification;
        $resolution->name = 'Разрешение';
        $resolution->description = 'Разрешение экрана или камеры устройства, выраженное в пикселях (например, 1920x1080).';
        $resolution->save();

        $waterResistance = new Specification;
        $waterResistance->name = 'Водонепроницаемость';
        $waterResistance->description = 'Уровень защиты от влаги или погружения в воду.';
        $waterResistance->save();
    }
}
