<?php

namespace App\Models;

use App\Http\Controllers\MainController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Manufacturer extends Model
{
    use HasFactory;

    protected $table = 'manufacturers';
    protected $guarded = ['id'];

    static public function search($query)
    {
        return Manufacturer::select()->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('country', 'LIKE', '%' . $query . '%')
            ->orderBy('name', 'ASC');
    }

    static public function sales($request = null)
    {
        return Manufacturer::select('manufacturers.name', DB::raw('SUM(order_products.count) as total_count'),
            DB::raw('count(DISTINCT orders.id) AS orders_count'),
            DB::raw('SUM(order_products.selling_price * order_products.count) AS costs_sum'))
            ->join('products', 'manufacturers.id', 'products.manufacturer_id')
            ->join('order_products', 'products.id', 'order_products.product_id')
            ->join('orders', 'orders.id', 'order_products.order_id')
            ->when($request->has('startDate') && !isEmpty($request->input('startDate')), function ($query) use ($request) {
                return $query->where('orders.date', '>=', $request->input('startDate'));
            })
            ->when($request->has('endDate') && !isEmpty($request->has('endDate')), function ($query) use ($request) {
                return $query->where('orders.date', '<=', $request->input('endDate'));
            })
            ->groupBy('manufacturers.name')
            ->having('name', 'LIKE', '%' . $request->input('search') . '%')
            ->orderBy('costs_sum', 'DESC', 'total_count', 'DESC');
    }

    static public function storeOrUpdate($request, $manufacturer = null)
    {
        if (is_null($manufacturer)) {
            $manufacturer = new Manufacturer;
        }
        $manufacturer->fill($request->all());
        $manufacturer->name = MainController::capitalizeFirstWord($request->name);
        $manufacturer->save();
    }

    static public function makeDefault()
    {
        $man = new Manufacturer;
        $man->name = 'AKG';
        $man->description = 'Одна из главных компаний музыкальной индустрии из америки';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Лос-Анджелес';
        $man->street = '157 авеню';
        $man->house = '864125';
        $man->post_index = '415256';
        $man->save();

        // Запись #2
        $man = new Manufacturer;
        $man->name = 'Fender';
        $man->description = 'Компания, производящая электрогитары и другие музыкальные инструменты.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Корона';
        $man->street = '17600 N. Perimeter Drive, Suite 100';
        $man->house = '90605';
        $man->post_index = '91720';
        $man->save();

// Запись #3
        $man = new Manufacturer;
        $man->name = 'Gibson';
        $man->description = 'Американская компания, производящая гитары, усилители и другие музыкальные инструменты.';
        $man->country = 'США';
        $man->region = 'Теннесси';
        $man->city = 'Нэшвилл';
        $man->street = '309 Plus Park Blvd';
        $man->house = '37217';
        $man->post_index = '37217';
        $man->save();

// Запись #4
        $man = new Manufacturer;
        $man->name = 'Roland';
        $man->description = 'Японская корпорация, специализирующаяся на производстве электронных музыкальных инструментов и другой аудио-визуальной техники.';
        $man->country = 'Япония';
        $man->region = 'Токио';
        $man->city = 'Хамаматсу-чо';
        $man->street = '1-7-2 Nakagawa, Sumida-ku';
        $man->house = '131-8714';
        $man->post_index = '131-8714';
        $man->save();

// Запись #5
        $man = new Manufacturer;
        $man->name = 'Yamaha';
        $man->description = 'Японская корпорация, производящая музыкальные инструменты, аудио-визуальное оборудование, мотоциклы и другую технику.';
        $man->country = 'Япония';
        $man->region = 'Токио';
        $man->city = 'Чикаго';
        $man->street = '6600 Orangethorpe Ave.';
        $man->house = '92801';
        $man->post_index = '92801';
        $man->save();

// Запись #6
        $man = new Manufacturer;
        $man->name = 'Casio';
        $man->description = 'Японская корпорация, производящая электронные музыкальные инструменты, научные калькуляторы и другую электронику.';
        $man->country = 'Япония';
        $man->region = 'Токио';
        $man->city = 'Токио';
        $man->street = '4125 Fanelia Ave.';
        $man->house = '52145';
        $man->post_index = '74324';
        $man->save();

        // Запись #7
        $man = new Manufacturer;
        $man->name = 'Korg';
        $man->description = 'Японская компания, производящая электронные музыкальные инструменты, синтезаторы и другую аудио-визуальную технику.';
        $man->country = 'Япония';
        $man->region = 'Токио';
        $man->city = 'Токио';
        $man->street = '15-12, Shimotakaido 1-chome, Suginami-ku';
        $man->house = '168-7';
        $man->post_index = '168-0072';
        $man->save();

// Запись #8
        $man = new Manufacturer;
        $man->name = 'Pearl';
        $man->description = 'Японская компания, производящая барабаны и другие ударные инструменты.';
        $man->country = 'Япония';
        $man->region = 'Токио';
        $man->city = 'Чиба';
        $man->street = '2-37-8 Wakaba';
        $man->house = '264-0034';
        $man->post_index = '264-0034';
        $man->save();

// Запись #9
        $man = new Manufacturer;
        $man->name = 'DW Drums';
        $man->description = 'Американская компания, производящая барабаны и другие ударные инструменты.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Окленд';
        $man->street = '3450 Lunar Ct';
        $man->house = '94601';
        $man->post_index = '94601';
        $man->save();

// Запись #10
        $man = new Manufacturer;
        $man->name = 'Sennheiser';
        $man->description = 'Немецкая компания, производящая аудио-технику, включая наушники, микрофоны и другое оборудование для профессионального и домашнего использования.';
        $man->country = 'Германия';
        $man->region = 'Ганновер';
        $man->city = 'Ведемаркт';
        $man->street = 'Am Labor 1';
        $man->house = '30900';
        $man->post_index = '30900';
        $man->save();

        // Запись #11
        $man = new Manufacturer;
        $man->name = 'Ibanez';
        $man->description = 'Японская компания, производящая гитары, бас-гитары и другие музыкальные инструменты.';
        $man->country = 'Япония';
        $man->region = 'Нагоя';
        $man->city = 'Нагоя';
        $man->street = '10-1, Higashi-Sakura 6-chome, Higashi-ku';
        $man->house = '461-8680';
        $man->post_index = '461-8680';
        $man->save();

// Запись #12
        $man = new Manufacturer;
        $man->name = 'Martin';
        $man->description = 'Американская компания, производящая акустические гитары.';
        $man->country = 'США';
        $man->region = 'Пенсильвания';
        $man->city = 'Назарет';
        $man->street = '510 Sycamore St.';
        $man->house = '18064';
        $man->post_index = '18064';
        $man->save();

// Запись #13
        $man = new Manufacturer;
        $man->name = 'Taylor';
        $man->description = 'Американская компания, специализирующаяся на производстве акустических гитар.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Эль-Каджон';
        $man->street = '1980 Gillespie Way';
        $man->house = '92020';
        $man->post_index = '92020';
        $man->save();

// Запись #14
        $man = new Manufacturer;
        $man->name = 'Epiphone';
        $man->description = 'Американская компания, производящая гитары и другие музыкальные инструменты.';
        $man->country = 'США';
        $man->region = 'Нью-Йорк';
        $man->city = 'Нью-Йорк';
        $man->street = '1510 Elmwood Ave.';
        $man->house = '14207';
        $man->post_index = '14207';
        $man->save();

// Запись #15
        $man = new Manufacturer;
        $man->name = 'Gretsch';
        $man->description = 'Американская компания, производящая гитары и другие музыкальные инструменты.';
        $man->country = 'США';
        $man->region = 'Джорджия';
        $man->city = 'Саванна';
        $man->street = '4278 Main St.';
        $man->house = '31404';
        $man->post_index = '31404';
        $man->save();
// Запись #16
        $man = new Manufacturer;
        $man->name = 'JBL';
        $man->description = 'Американская компания, специализирующаяся на производстве акустических систем, колонок и другой аудиотехники.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Лос-Анджелес';
        $man->street = '8500 Balboa Blvd.';
        $man->house = '91329';
        $man->post_index = '91329';
        $man->save();

// Запись #17
        $man = new Manufacturer;
        $man->name = 'Focusrite';
        $man->description = 'Британская компания, производящая аудиоинтерфейсы, предусилители и другое аудиооборудование для студийной записи.';
        $man->country = 'Великобритания';
        $man->region = 'Беркшир';
        $man->city = 'Рошемптон';
        $man->street = 'Windsor House, Turnpike Road';
        $man->house = 'RG10 0TR';
        $man->post_index = 'RG10 0TR';
        $man->save();

// Запись #18
        $man = new Manufacturer;
        $man->name = 'KRK Systems';
        $man->description = 'Американская компания, производящая студийные мониторы и акустические системы для профессиональной звукозаписи.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Остин';
        $man->street = '4444 Riverside Drive';
        $man->house = '78741';
        $man->post_index = '78741';
        $man->save();

// Запись #19
        $man = new Manufacturer;
        $man->name = 'Neumann';
        $man->description = 'Немецкая компания, специализирующаяся на производстве микрофонов для профессиональной звукозаписи и широкого спектра аудиооборудования.';
        $man->country = 'Германия';
        $man->region = 'Берлин';
        $man->city = 'Берлин';
        $man->street = 'Gustav-Heinemann-Ufer 72a';
        $man->house = '50968';
        $man->post_index = '50968';
        $man->save();

// Запись #20
        $man = new Manufacturer;
        $man->name = 'M-Audio';
        $man->description = 'Американская компания, производящая аудиоинтерфейсы, MIDI-клавиатуры, студийные мониторы и другое аудиооборудование для домашней и профессиональной студии.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Ирвайн';
        $man->street = '5795 Lindero Canyon Road';
        $man->house = '92612';
        $man->post_index = '92612';
        $man->save();
// Запись #21
        $man = new Manufacturer;
        $man->name = 'Pioneer';
        $man->description = 'Японская компания, производящая аудио- и видеотехнику, включая наушники, диджейское оборудование и домашние кинотеатры.';
        $man->country = 'Япония';
        $man->region = 'Токио';
        $man->city = 'Токио';
        $man->street = '1-1, Shin-ogawa-machi, Shinjuku-ku';
        $man->house = '162-0814';
        $man->post_index = '162-0814';
        $man->save();

// Запись #22
        $man = new Manufacturer;
        $man->name = 'Behringer';
        $man->description = 'Немецкая компания, производящая аудиооборудование, включая микшеры, эффекты, акустические системы и другое профессиональное и домашнее аудиооборудование.';
        $man->country = 'Германия';
        $man->region = 'Вильгельмсдорф';
        $man->city = 'Мансфельдер';
        $man->street = 'Rathenaustr. 18-20';
        $man->house = '06366';
        $man->post_index = '06366';
        $man->save();

// Запись #23
        $man = new Manufacturer;
        $man->name = 'Shure';
        $man->description = 'Американская компания, специализирующаяся на производстве микрофонов, наушников и другого аудиооборудования для профессионального использования.';
        $man->country = 'США';
        $man->region = 'Иллинойс';
        $man->city = 'Напервилл';
        $man->street = '5800 W Touhy Ave';
        $man->house = '60053';
        $man->post_index = '60053';
        $man->save();

// Запись #24
        $man = new Manufacturer;
        $man->name = 'Alesis';
        $man->description = 'Американская компания, производящая электронные ударные инструменты, MIDI-клавиатуры, синтезаторы и другое музыкальное оборудование.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Кумберленд';
        $man->street = '200 Scenic View Drive';
        $man->house = '02864';
        $man->post_index = '02864';
        $man->save();

// Запись #25
        $man = new Manufacturer;
        $man->name = 'Mackie';
        $man->description = 'Американская компания, производящая аудиооборудование для студий и живого звука, включая микшеры, активные акустические системы и мониторы.';
        $man->country = 'США';
        $man->region = 'Вашингтон';
        $man->city = 'Вудивилл';
        $man->street = '16220 Wood-Red Road NE';
        $man->house = '98072';
        $man->post_index = '98072';
        $man->save();

        // Запись #26
        $man = new Manufacturer;
        $man->name = 'Universal Audio';
        $man->description = 'Американская компания, специализирующаяся на производстве аудиоинтерфейсов и оборудования для звукозаписи.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Санта-Крус';
        $man->street = '1700 Green Hills Rd';
        $man->house = '95066';
        $man->post_index = '95066';
        $man->save();

// Запись #28
        $man = new Manufacturer;
        $man->name = 'Electro-Voice';
        $man->description = 'Американская компания, производитель акустических систем, микрофонов и другого аудиооборудования.';
        $man->country = 'США';
        $man->region = 'Миннесота';
        $man->city = 'Бернсвилл';
        $man->street = '12000 Portland Ave S';
        $man->house = '55337';
        $man->post_index = '55337';
        $man->save();

// Запись #29
        $man = new Manufacturer;
        $man->name = 'PreSonus';
        $man->description = 'Американская компания, производитель аудиоинтерфейсов, микшерных пультов и программного обеспечения для звукозаписи.';
        $man->country = 'США';
        $man->region = 'Луизиана';
        $man->city = 'Батон-Руж';
        $man->street = '18011 Highland Market Dr';
        $man->house = '70810';
        $man->post_index = '70810';
        $man->save();

// Запись #30
        $man = new Manufacturer;
        $man->name = 'Steinberg';
        $man->description = 'Немецкая компания, специализирующаяся на разработке программного обеспечения для звукозаписи и создания музыки.';
        $man->country = 'Германия';
        $man->region = 'Гамбург';
        $man->city = 'Гамбург';
        $man->street = 'Frankenstraße 18 b';
        $man->house = '20097';
        $man->post_index = '20097';
        $man->save();

// Запись #31
        $man = new Manufacturer;
        $man->name = 'Image-Line';
        $man->description = 'Бельгийская компания, специализирующаяся на разработке программного обеспечения для создания музыки и звукозаписи, включая популярный DAW FL Studio.';
        $man->country = 'Бельгия';
        $man->region = 'Гент';
        $man->city = 'Гент';
        $man->street = 'Coupure Links 101';
        $man->house = '9000';
        $man->post_index = '9000';
        $man->save();
// Запись #32
        $man = new Manufacturer;
        $man->name = 'Apple';
        $man->description = 'Международная технологическая компания, производитель компьютеров, смартфонов, планшетов, аудио- и видеоустройств, программного обеспечения и других электронных устройств.';
        $man->country = 'США';
        $man->region = 'Калифорния';
        $man->city = 'Купертино';
        $man->street = '1 Apple Park Way';
        $man->house = '95014';
        $man->post_index = '95014';
        $man->save();


    }
}
