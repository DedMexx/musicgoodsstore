<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = ['id'];

    static public function search($query)
    {
        return Category::select()
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orderBy('name', 'ASC');
    }

    static public function sales($request)
    {
        return Category::select('categories.name', DB::raw('SUM(order_products.count) AS total_count'),
            DB::raw('count(DISTINCT orders.id) AS orders_count'),
            DB::raw('SUM(order_products.selling_price * order_products.count) AS costs_sum'))
            ->join('category_products', 'categories.id', 'category_products.category_id')
            ->join('products', 'category_products.product_id', 'products.id')
            ->join('order_products', 'products.id', 'order_products.product_id')
            ->join('orders', 'orders.id', 'order_id')
            ->when($request->has('startDate'), function ($query) use ($request) {
                return $query->where('orders.date', '>=', $request->input('startDate'));
            })
            ->when($request->has('endDate'), function ($query) use ($request) {
                return $query->where('orders.date', '<=', $request->input('endDate'));
            })
            ->groupBy('categories.name')
            ->having('name', 'LIKE', '%' . $request->input('search') . '%')
            ->orderBy('costs_sum', 'DESC', 'total_count', 'DESC');
    }

    static public function storeOrUpdate($request, $category = null)
    {
        if (is_null($category)) {
            $category = new Category;
        }
        $category->name = MainController::capitalizeFirstWord($request->name);
        $category->description = $request->description;
        $category->save();
    }

    static public function makeDefault()
    {
        $electricGuitar = new Category;
        $electricGuitar->name = 'Электрические гитары';
        $electricGuitar->description = 'Это гитары, оснащенные электромагнитными звукоснимателями, которые позволяют создавать звуки с использованием электрического усиления. Электрические гитары обычно используются в различных жанрах популярной музыки, таких как рок, металл, блюз и джаз.';
        $electricGuitar->save();

        $acousticGuitar = new Category;
        $acousticGuitar->name = 'Акустические гитары';
        $acousticGuitar->description = 'Это гитары, которые не требуют использования электрического усиления для производства звука. Они обычно имеют полностью акустическую конструкцию с резонирующей декой и используются для исполнения различных музыкальных жанров, включая фолк, кантри, блюз и популярную музыку.';
        $acousticGuitar->save();

        $bassGuitar = new Category;
        $bassGuitar->name = 'Бас-гитары';
        $bassGuitar->description = 'Это гитары, специально разработанные для игры низких звуковых нот, используемых в ритмическом и гармоническом аккомпанементе. Бас-гитары широко применяются в жанрах, таких как рок, фанк, джаз и регги.';
        $bassGuitar->save();

        $classicalGuitar = new Category;
        $classicalGuitar->name = 'Классические гитары';
        $classicalGuitar->description = 'Это гитары с нейлоновыми струнами и особой конструкцией, которые используются для исполнения классической музыки. Классические гитары обладают характерным звучанием и широко используются в концертных выступлениях и академической музыке.';
        $classicalGuitar->save();

        $cat = new Category;
        $cat->name = 'Клавишные инструменты';
        $cat->description = 'Это музыкальные инструменты, у которых звук производится путем нажатия клавиш. Они используются в широком диапазоне музыкальных жанров, от классической музыки до электронной.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'Ударные инструменты';
        $cat->description = 'Это музыкальные инструменты, которые производят звук путем удара по ним палочками, молотками или руками. Они используются в различных жанрах музыки, от рока до джаза.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'Духовые инструменты';
        $cat->description = 'Это музыкальные инструменты, у которых звук производится путем дуновения в них воздуха. Они используются в различных музыкальных жанрах, от джаза до классики.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'Струнные инструменты';
        $cat->description = 'Это музыкальные инструменты, у которых звук производится путем колебания струн. Они используются в широком диапазоне музыкальных жанров, от классической музыки до фольклора.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'Аксессуары';
        $cat->description = 'Это различные предметы, которые используются для поддержки и обслуживания музыкального инструмента, звуковой системы или оборудования. К ним могут относиться чехлы, стойки, кабели, педали, наушники и другие предметы.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'Концертное оборудование';
        $cat->description = 'Это оборудование, используемое для проведения концертов и выступлений. К нему могут относиться микшерные пульты, акустические системы, усилители, мониторы, световое оборудование и другие элементы.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'Студийное оборудование';
        $cat->description = 'Это оборудование, используемое для создания и записи музыки в студии. К нему могут относиться микрофоны, наушники, звуковые карты, мониторы, секвенсоры и другие элементы.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'Световое оборудование';
        $cat->description = 'Это оборудование, используемое для освещения сцены и создания визуальной атмосферы на концертах и выступлениях. К нему могут относиться светильники, прожекторы, специальные эффекты и другие элементы.';
        $cat->save();

        $cat = new Category;
        $cat->name = 'DJ оборудование';
        $cat->description = 'Это оборудование, используемое для профессионального диджеинга. К нему могут относиться DJ-пульты, проигрыватели, наушники, акустические системы и другие элементы.';
        $cat->save();

        $audioInterface = new Category;
        $audioInterface->name = 'Аудиоинтерфейсы';
        $audioInterface->description = 'Это устройства, которые позволяют подключить музыкальные инструменты или микрофоны к компьютеру для записи или обработки звука. Аудиоинтерфейсы обычно имеют различные входы и выходы, а также функции управления звуком.';
        $audioInterface->save();

        $microphone = new Category;
        $microphone->name = 'Микрофоны';
        $microphone->description = 'Это устройства для преобразования звуковых колебаний в электрические сигналы. Микрофоны используются для записи звука в студиях, на концертах, вещании, видеопроизводстве и других областях, где требуется высококачественный звук.';
        $microphone->save();

        $midiController = new Category;
        $midiController->name = 'MIDI-контроллеры';
        $midiController->description = 'Это устройства для управления звуками и музыкальными приложениями с помощью протокола MIDI (Musical Instrument Digital Interface). MIDI-контроллеры могут быть клавиатурными, пэдами, фейдерами или другими элементами управления.';
        $midiController->save();

        $studioMonitor = new Category;
        $studioMonitor->name = 'Студийные мониторы';
        $studioMonitor->description = 'Это активные акустические системы, специально разработанные для использования в студиях звукозаписи. Студийные мониторы обеспечивают точное и нейтральное воспроизведение звука, что позволяет музыкантам и звукоинженерам услышать детали и ошибки в музыке.';
        $studioMonitor->save();

        $musicProductionSoftware = new Category;
        $musicProductionSoftware->name = 'Программное обеспечение для музыкального производства';
        $musicProductionSoftware->description = 'Это специализированное программное обеспечение, которое позволяет создавать, записывать, редактировать и обрабатывать музыку на компьютере. Оно включает секвенсоры, виртуальные инструменты, эффекты и другие инструменты для творческой работы с звуком.';
        $musicProductionSoftware->save();

        $guitarEffectsPedal = new Category;
        $guitarEffectsPedal->name = 'Педали гитарных эффектов';
        $guitarEffectsPedal->description = 'Это устройства, которые изменяют звук электрической гитары, добавляя различные эффекты, такие как искажение, задержка, хорус, фазер и другие. Педали гитарных эффектов позволяют гитаристам создавать уникальные звуковые эффекты.';
        $guitarEffectsPedal->save();

        $drumMachine = new Category;
        $drumMachine->name = 'Драм-машины';
        $drumMachine->description = 'Это электронные устройства или программы, предназначенные для создания и воспроизведения ритмических паттернов и звуков ударных инструментов. Драм-машины широко используются в электронной музыке и ритмическом программировании.';
        $drumMachine->save();

        $audioRecorder = new Category;
        $audioRecorder->name = 'Аудиорекордеры';
        $audioRecorder->description = 'Это устройства или программы, предназначенные для записи звука в различных ситуациях, включая полевые записи, интервью, звукозапись концертов и других музыкальных мероприятий. Аудиорекордеры обеспечивают высокое качество записи и удобство использования.';
        $audioRecorder->save();

        $digitalPiano = new Category;
        $digitalPiano->name = 'Цифровые пианино';
        $digitalPiano->description = 'Это электронные клавишные инструменты, которые имитируют звук и ощущение акустического пианино. Цифровые пианино обычно обладают различными звуковыми настройками, встроенными эффектами и возможностью подключения к компьютеру или другим устройствам.';
        $digitalPiano->save();

        $synthesizer = new Category;
        $synthesizer->name = 'Синтезаторы';
        $synthesizer->description = 'Это электронные инструменты, способные создавать различные звуки и эффекты с помощью синтеза звука. Синтезаторы могут имитировать звуки других инструментов, а также создавать уникальные и экспериментальные звуковые текстуры.';
        $synthesizer->save();

        $turntable = new Category;
        $turntable->name = 'Виниловые проигрыватели';
        $turntable->description = 'Это устройства для воспроизведения аналоговых звукозаписей на виниловых пластинках. Виниловые проигрыватели используются в аудиофильских системах и DJ-оборудовании для наслаждения аналоговым звуком и сведения музыки.';
        $turntable->save();

        $guitarAmplifier = new Category;
        $guitarAmplifier->name = 'Гитарные усилители';
        $guitarAmplifier->description = 'Это устройства, используемые для усиления звука электрической гитары. Гитарные усилители обеспечивают усиление и изменение тембра гитарного сигнала, а также предоставляют различные эффекты и настройки.';
        $guitarAmplifier->save();

        $headphones = new Category;
        $headphones->name = 'Наушники';
        $headphones->description = 'Наушники - это аудиоустройства, которые надеваются на уши для прослушивания звука. Они обеспечивают индивидуальное воспроизведение звука и позволяют наслаждаться музыкой или другими аудио материалами без помех извне.';
        $headphones->save();
    }
}
