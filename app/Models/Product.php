<?php

namespace App\Models;

use App\Http\Controllers\MainController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    static public function search($query)
    {
        return Product::select('products.*')
            ->distinct('products.id')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->leftJoin('category_products', 'category_products.product_id', 'products.id')
            ->orWhereIn('category_id', Category::select('id')
                ->where('name', 'LIKE', '%' . $query . '%'))
            ->orWhereIn('manufacturer_id', Manufacturer::select('id')
                ->where('name', 'LIKE', '%' . $query . '%'))
            ->orderBy('name', 'ASC');
    }

    static public function getProfit($request) {
        return Product::select('order_id', 'name',
            DB::raw('SUM((order_products.selling_price-products.purchase_price)*`count`) AS profit,
            SUM(count) AS count'))
            ->when($request->input('startDate'), function ($query, $startDate) {
                return $query->where('date', '>=', $startDate);
            })
            ->when($request->input('endDate'), function ($query, $endDate) {
                return $query->where('date', '<=', $endDate);
            })
            ->join('order_products', 'products.id', 'product_id')
            ->join('orders', 'order_id', 'orders.id')
            ->groupBy(DB::raw('order_id, name WITH ROLLUP'));
    }

    static public function storeOrUpdate($request, $product = null)
    {
        if ($product === null) {
            $product = new Product;
        } else {
            $imageName = $product->image;
        }
        $product->fill($request->except('image'));


        $manufacturer = Manufacturer::where('name', $request->manufacturer)->first();
        if (!$manufacturer) {
            $manufacturer = Manufacturer::create(['name' => $request->manufacturer]);
        }
        $product->manufacturer_id = $manufacturer->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = MainController::generateUniqueFileNameForProducts($image);
            $image->move(public_path('images/products'), $imageName);
            if ($product->image) {
                unlink(public_path('images/products/' . $product->image));
            }
        }

        $product->image = $imageName;
        $product->save();

        SpecificationProduct::changeProductsSpecifications($request, $product);
        CategoryProduct::changeProductsCategories($request, $product);

        if (CategoryProduct::where('product_id', $product->id)->get()->isEmpty()) {
            unlink(public_path('images/products/' . $product->image));
            $product->delete();
            return 'noCategory';
        }

        if (SpecificationProduct::where('product_id', $product->id)->get()->isEmpty()) {
            unlink(public_path('images/products/' . $product->image));
            $product->delete();
            return 'noSpecification';
        }

        return $product;
    }

    static public function makeDefault()
    {
        $product = new Product;
        $product->name = 'Yamaha Pacific';
        $product->description = 'Yamaha Pacifica – это серия электрических гитар, известных своим отличным качеством звука и доступной ценой. Эти гитары предлагают широкий спектр звуков и стилей благодаря комбинации качественных звукоснимателей и гибкой электроники. Корпус гитары изготовлен из высококачественных материалов, обеспечивая отличную играбельность и долговечность. Yamaha Pacifica идеально подходит как для начинающих музыкантов, так и для опытных гитаристов, и стала одной из самых популярных моделей среди любителей электрических гитар. Независимо от вашего музыкального стиля, Yamaha Pacifica обеспечит вам прекрасный звук и надежность на сцене и в студии.';
        $product->image = 'img1.png';
        $product->quantity = 20;
        $product->purchase_price = 11999.50;
        $product->selling_price = 15499.49;
        $product->warranty = '2 года';
        $product->manufacturer_id = 5;
        $product->save();

        $product1 = new Product;
        $product1->name = 'Fender Stratocaster';
        $product1->description = 'Легендарная электрогитара от Fender';
        $product1->image = 'img2.png';
        $product1->quantity = 25;
        $product1->purchase_price = 32000.00;
        $product1->selling_price = 42000.00;
        $product1->warranty = '3 года';
        $product1->manufacturer_id = 2;
        $product1->save();

        $product2 = new Product;
        $product2->name = 'Gibson Les Paul';
        $product2->description = 'Известная модель электрогитар от Gibson';
        $product2->image = 'img3.png';
        $product2->quantity = 11;
        $product2->purchase_price = 45000.00;
        $product2->selling_price = 58000.00;
        $product2->warranty = '2 года';
        $product2->manufacturer_id = 3;
        $product2->save();

        $product3 = new Product;
        $product3->name = 'Yamaha P-45';
        $product3->description = 'Электронное пианино с молоточковой механикой от Yamaha';
        $product3->image = 'img4.png';
        $product3->quantity = 18;
        $product3->purchase_price = 30000.00;
        $product3->selling_price = 39000.00;
        $product3->warranty = '1 год';
        $product3->manufacturer_id = 5;
        $product3->save();

        $product4 = new Product;
        $product4->name = 'Roland TD-17KV';
        $product4->description = 'Электронная ударная установка с функцией записи';
        $product4->image = 'img5.png';
        $product4->quantity = 0;
        $product4->purchase_price = 48000.00;
        $product4->selling_price = 62000.00;
        $product4->warranty = '2 года';
        $product4->manufacturer_id = 4;
        $product4->save();

        $product5 = new Product;
        $product5->name = 'Ibanez RG550';
        $product5->description = 'Электрогитара с двумя звукоснимателями от Ibanez';
        $product5->image = 'img6.png';
        $product5->quantity = 33;
        $product5->purchase_price = 25000.00;
        $product5->selling_price = 33000.00;
        $product5->warranty = '2 года';
        $product5->manufacturer_id = 11;
        $product5->save();

        $product6 = new Product;
        $product6->name = 'Gretsch G5420T';
        $product6->description = 'Семиструнная гитара с Bigsby-вибрато от Gretsch';
        $product6->image = 'img7.png';
        $product6->quantity = 44;
        $product6->purchase_price = 45000.00;
        $product6->selling_price = 59000.00;
        $product6->warranty = '3 года';
        $product6->manufacturer_id = 15;
        $product6->save();

        $product7 = new Product;
        $product7->name = 'Taylor 214ce';
        $product7->description = 'Акустическая гитара с красивой отделкой от Taylor';
        $product7->image = 'img8.png';
        $product7->quantity = 4;
        $product7->purchase_price = 38000.00;
        $product7->selling_price = 50000.00;
        $product7->warranty = '2 года';
        $product7->manufacturer_id = 13;
        $product7->save();

        $product = new Product;
        $product->name = 'Apple AirPods Pro';
        $product->description = 'Apple AirPods Pro - это беспроводные наушники, которые обеспечивают высококачественное звучание и удобство использования. Они оснащены активной шумоизоляцией, позволяющей наслаждаться музыкой без посторонних шумов. AirPods Pro имеют удобный дизайн, отличную автономность и простое подключение к устройствам Apple.';
        $product->image = 'img9.png';
        $product->quantity = 50;
        $product->purchase_price = 19999.00;
        $product->selling_price = 24999.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 31;
        $product->save();


        $product = new Product;
        $product->name = 'Image-Line FL Studio';
        $product->description = 'Image-Line FL Studio – это мощное программное обеспечение для создания музыки. Оно предлагает широкий спектр инструментов и эффектов, а также интуитивно понятный интерфейс, что делает процесс создания музыки легким и увлекательным. FL Studio подходит как для начинающих музыкантов, так и для профессионалов.';
        $product->image = 'img10.png';
        $product->quantity = 10;
        $product->purchase_price = 499.99;
        $product->selling_price = 599.99;
        $product->warranty = 'Без гарантии';
        $product->manufacturer_id = 30;
        $product->save();

        $product = new Product;
        $product->name = 'Steinberg Cubase Pro';
        $product->description = 'Steinberg Cubase Pro – это профессиональное программное обеспечение для звукозаписи и аудиопроизводства. Оно обладает широким набором функций, включая мощный секвенсор, встроенные инструменты, эффекты и возможность обработки звука на высоком уровне. Cubase Pro является выбором многих профессиональных музыкантов и звукорежиссеров.';
        $product->image = 'img11.png';
        $product->quantity = 5;
        $product->purchase_price = 899.99;
        $product->selling_price = 1099.99;
        $product->warranty = 'Без гарантии';
        $product->manufacturer_id = 29;
        $product->save();

        $product = new Product;
        $product->name = 'PreSonus StudioLive Mixer';
        $product->description = 'PreSonus StudioLive Mixer – это мощный микшерный пульт, предназначенный для живого звукового усиления и записи. Он обладает высоким качеством звука, множеством входов и выходов, а также интуитивно понятным интерфейсом, что делает его идеальным выбором для концертов и студийной работы.';
        $product->image = 'img12.png';
        $product->quantity = 8;
        $product->purchase_price = 1999.99;
        $product->selling_price = 2499.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 28;
        $product->save();

        $product = new Product;
        $product->name = 'Electro-Voice ZLX-12BT';
        $product->description = 'Electro-Voice ZLX-12BT - активная двухполосная акустическая система с встроенным Bluetooth-приемником. Она предлагает высококачественное воспроизведение звука с четкими высокими и глубокими низкими частотами. Акустическая система компактна и легкая, что делает ее идеальным выбором для мобильных выступлений и установок в небольших помещениях. Electro-Voice ZLX-12BT обеспечивает мощный звук и надежную производительность, удовлетворяя требованиям как профессиональных музыкантов, так и звукорежиссеров.';
        $product->image = 'img13.png';
        $product->quantity = 10;
        $product->purchase_price = 8999.00;
        $product->selling_price = 10999.99;
        $product->warranty = '3 года';
        $product->manufacturer_id = 27;
        $product->save();

        $product = new Product;
        $product->name = 'Universal Audio Apollo Twin X DUO';
        $product->description = 'Universal Audio Apollo Twin X DUO - это аудиоинтерфейс высокого качества, разработанный для профессиональной звукозаписи. Он оснащен двумя входами с предусилителями и эмуляцией классических студийных эффектов, таких как компрессоры и эквалайзеры. Аудиоинтерфейс обладает высокой скоростью передачи данных и низкой задержкой, обеспечивая высокую точность и четкость звукозаписи. Universal Audio Apollo Twin X DUO совместим с популярными программами для звукозаписи и обработки звука, делая его идеальным выбором для профессиональных музыкантов и звукорежиссеров.';
        $product->image = 'img14.png';
        $product->quantity = 5;
        $product->purchase_price = 25999.00;
        $product->selling_price = 29999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 26;
        $product->save();

        $product = new Product;
        $product->name = 'Mackie CR3';
        $product->description = 'Mackie CR3 - это компактные активные мультимедийные мониторы, идеально подходящие для использования в домашней студии или для настольной работы. Они обеспечивают качественное воспроизведение звука с четкой детализацией и широким динамическим диапазоном. Mackie CR3 оснащены встроенным усилителем класса AB, мощностью 50 Вт и 3" динамиками с высоким разрешением. Они также имеют встроенный регулятор громкости и высокочастотного уровня, а также подключения для наушников и устройств с внешним источником сигнала.';
        $product->image = 'img15.png';
        $product->quantity = 15;
        $product->purchase_price = 2999.99;
        $product->selling_price = 3999.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 25;
        $product->save();

        $product = new Product;
        $product->name = 'Alesis Nitro Mesh Kit';
        $product->description = 'Alesis Nitro Mesh Kit - это электронная ударная установка с мягкими меш-пэдами, обеспечивающими реалистичное ощущение и отличную играбельность. Установка включает в себя 8" двойное меш-пэд для бас-барабана, 3 меш-пэда для томов, 3 пэда для пэда для тарелок (хай-хет, креш и райд), а также пэд для хэт-контроллера и пэд для контроллера бас-барабана. Alesis Nitro Mesh Kit также включает в себя модуль с более чем 350 звуками, 60 треками и встроенным метрономом. Он также имеет USB/MIDI-интерфейс для подключения к компьютеру и возможности записи. В комплекте также идет стойка для установки и педаль для бас-барабана.';
        $product->image = 'img16.png';
        $product->quantity = 10;
        $product->purchase_price = 16999.00;
        $product->selling_price = 19999.00;
        $product->warranty = '2 года';
        $product->manufacturer_id = 24;
        $product->save();

        $product = new Product;
        $product->name = 'Shure SM58';
        $product->description = 'Shure SM58 - это динамический микрофон с высокой чувствительностью и качественной передачей звука. Он обладает прочным корпусом и специальной сеткой, которая защищает от возможных повреждений. Микрофон Shure SM58 идеально подходит для живых выступлений и студийной записи.';
        $product->image = 'img17.png';
        $product->quantity = 10;
        $product->purchase_price = 7999.99;
        $product->selling_price = 9999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 23;
        $product->save();

        $product = new Product;
        $product->name = 'Behringer X32';
        $product->description = 'Behringer X32 - это цифровая микшерная консоль с множеством возможностей. Она обладает высоким качеством звука, множеством входов и выходов, а также интуитивным интерфейсом. Микшерная консоль Behringer X32 является отличным выбором для профессиональных звукорежиссеров и музыкантов.';
        $product->image = 'img18.png';
        $product->quantity = 5;
        $product->purchase_price = 49999.99;
        $product->selling_price = 59999.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 22;
        $product->save();

        $product = new Product;
        $product->name = 'Pioneer DJM-900NXS2';
        $product->description = 'Pioneer DJM-900NXS2 - это профессиональный DJ-микшер с множеством функций. Он обладает высоким качеством звука, интуитивным управлением и широкими возможностями для создания смешиваний и эффектов. Микшер Pioneer DJM-900NXS2 является идеальным инструментом для профессиональных диджеев.';
        $product->image = 'img19.png';
        $product->quantity = 3;
        $product->purchase_price = 79999.99;
        $product->selling_price = 89999.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 21;
        $product->save();

        $product = new Product;
        $product->name = 'M-Audio Oxygen 49';
        $product->description = 'M-Audio Oxygen 49 - это MIDI-клавиатура с 49 полноразмерными динамическими клавишами и широким набором контролов. Она идеально подходит для создания музыки на компьютере и виртуальных инструментов. Клавиатура оснащена сенсорными полосами для управления выражением и модуляцией, а также программными колесами для управления звуками. M-Audio Oxygen 49 обеспечивает высокую точность и отзывчивость, что делает ее отличным выбором для профессионалов и начинающих музыкантов.';
        $product->image = 'img20.png';
        $product->quantity = 15;
        $product->purchase_price = 5999.00;
        $product->selling_price = 7999.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 20;
        $product->save();

        $product = new Product;
        $product->name = 'Neumann U87';
        $product->description = 'Neumann U87 - это легендарный конденсаторный микрофон, широко признанный своим высоким качеством звука и универсальностью. Он часто используется в профессиональных студиях звукозаписи и звуковом оборудовании для записи вокала, инструментов и акустических источников. Neumann U87 обладает превосходной детализацией, широкой динамической характеристикой и низким уровнем шума, что делает его идеальным инструментом для требовательных аудиозаписей. Этот микрофон - незаменимое средство для профессионалов, которые стремятся достичь высочайшего качества звучания.';
        $product->image = 'img21.png';
        $product->quantity = 10;
        $product->purchase_price = 27999.00;
        $product->selling_price = 34999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 19;
        $product->save();

        $product = new Product;
        $product->name = 'KRK Rokit 5 G4';
        $product->description = 'KRK Rokit 5 G4 - это активные студийные мониторы с превосходным качеством звука. Они обеспечивают точную и нейтральную передачу звука, что делает их идеальными для микширования и мастеринга. Мониторы имеют удобные настройки и подключения, а также стильный и компактный дизайн. KRK Rokit 5 G4 позволит вам услышать каждую нюанс звука и достичь высокого качества ваших музыкальных проектов.';
        $product->image = 'img22.png';
        $product->quantity = 10;
        $product->purchase_price = 6999.99;
        $product->selling_price = 8499.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 18;
        $product->save();

        $product = new Product;
        $product->name = 'Focusrite Scarlett 2i2';
        $product->description = 'Focusrite Scarlett 2i2 - это аудиоинтерфейс высокого качества, предназначенный для записи звука. Он обладает двумя комбо-входами, которые поддерживают микрофоны и инструменты с высокой чувствительностью. Scarlett 2i2 обеспечивает чистый и кристально четкий звук, а также имеет низкий уровень шума. Интерфейс подключается к компьютеру через USB и совместим с различными программами для записи. Focusrite Scarlett 2i2 поможет вам создавать профессиональные звукозаписи в домашней студии или в пути.';
        $product->image = 'img23.png';
        $product->quantity = 15;
        $product->purchase_price = 4999.50;
        $product->selling_price = 5999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 17;
        $product->save();

        $product = new Product;
        $product->name = 'JBL Flip 5';
        $product->description = 'JBL Flip 5 - это портативная Bluetooth-колонка с мощным звуком. Она обладает прочным корпусом, защитой от влаги и длительным временем работы от аккумулятора. Колонка Flip 5 от JBL позволяет наслаждаться любимой музыкой в любых условиях и создавать атмосферу праздника.';
        $product->image = 'img24.png';
        $product->quantity = 30;
        $product->purchase_price = 5999.00;
        $product->selling_price = 7999.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 16;
        $product->save();

        $product = new Product;
        $product->name = 'Gretsch G2622 Streamliner';
        $product->description = 'Gretsch G2622 Streamliner - это полуакустическая гитара с ярким и насыщенным звуком. Она обладает элегантным дизайном, комфортной играбельностью и высоким качеством звукоснимателей. Гитара G2622 Streamliner от Gretsch подойдет как для студийной работы, так и для живых выступлений.';
        $product->image = 'img25.png';
        $product->quantity = 15;
        $product->purchase_price = 21999.00;
        $product->selling_price = 26999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 15;
        $product->save();

        $product = new Product;
        $product->name = 'Epiphone Les Paul Standard';
        $product->description = 'Epiphone Les Paul Standard - классическая электрическая гитара с историей, известная своим теплым звуком и отличным дизайном. Она обладает красивым корпусом из красного дерева, с красивыми кленовыми верхними деревянными накладками, и предлагает широкий спектр звуков и стилей благодаря двум качественным звукоснимателям. Epiphone Les Paul Standard отлично подходит для игры в различных жанрах музыки и является одной из самых популярных моделей в серии Epiphone Les Paul. Гитара предлагает отличное сочетание качества, цены и звука.';
        $product->image = 'img26.png';
        $product->quantity = 15;
        $product->purchase_price = 8999.99;
        $product->selling_price = 12499.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 14;
        $product->save();

        $product = new Product;
        $product->name = 'Taylor 814ce';
        $product->description = 'Taylor 814ce - электроакустическая гитара высокого качества, известная своим прекрасным звуком и эстетическим дизайном. Она оснащена красивым корпусом из высококачественного дерева, с эргономичной формой и ярким звуком. Taylor 814ce имеет встроенную электронику, которая позволяет подключить гитару к усилителю или звуковой системе. Эта гитара идеально подходит для профессиональных музыкантов и студийной работы. Taylor 814ce является одной из самых престижных моделей в серии Taylor и предлагает превосходное качество звука и отличную играбельность.';
        $product->image = 'img27.png';
        $product->quantity = 10;
        $product->purchase_price = 19999.99;
        $product->selling_price = 24999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 13;
        $product->save();

        $product = new Product;
        $product->name = 'Martin D-28';
        $product->description = 'Martin D-28 - это легендарная акустическая гитара, которая известна своим превосходным качеством звука и великолепным дизайном. Изготовленная из отборных материалов, включая массив ели и розовое дерево, гитара Martin D-28 обеспечивает богатый и полный звук с отличной проекцией. Эта модель имеет комфортную гриф и отличную играбельность, делая ее идеальным выбором для профессиональных гитаристов и энтузиастов музыки. Martin D-28 - это настоящий шедевр, который прослужит вам долгие годы и станет надежным спутником на сцене и в студии.';
        $product->image = 'img28.png';
        $product->quantity = 10;
        $product->purchase_price = 29999.99;
        $product->selling_price = 37999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 12;
        $product->save();

        $product = new Product;
        $product->name = 'Ibanez RG750';
        $product->description = 'Ibanez RG750 - это электрическая гитара, которая является одной из самых популярных моделей этого производителя. Сочетая в себе стильный дизайн и отличное качество звука, Ibanez RG550 предлагает широкий спектр звуковых возможностей для гитаристов различных стилей. Гитара оснащена комфортным грифом и высококачественными звукоснимателями, обеспечивающими яркий и насыщенный звук. Ibanez RG550 идеально подходит для игры в стиле рок, металл и других жанров, где требуется высокая скорость и точность игры. Если вы ищете гитару с отличными игровыми характеристиками и современным дизайном, Ibanez RG550 - отличный выбор.';
        $product->image = 'img29.png';
        $product->quantity = 15;
        $product->purchase_price = 15999.00;
        $product->selling_price = 19999.00;
        $product->warranty = '1 год';
        $product->manufacturer_id = 11;
        $product->save();

        $product = new Product;
        $product->name = 'Sennheiser HD 650';
        $product->description = 'Sennheiser HD 650 - это открытые наушники высокого разрешения, предназначенные для аудиофилов и профессиональных музыкантов. Они обладают широким диапазоном частот, точной передачей звука и высоким уровнем комфорта. HD 650 оснащены высококачественными звуковыми драйверами и открытой конструкцией, которая создает просторное звуковое пространство и естественное звучание. Наушники имеют регулируемую оголовье и мягкие амбушюры для комфортной носки длительное время. Sennheiser HD 650 - это идеальный выбор для прослушивания музыки, микширования и мастеринга в студии или для наслаждения качественным звуком дома.';
        $product->image = 'img30.png';
        $product->quantity = 10;
        $product->purchase_price = 27999.00;
        $product->selling_price = 32999.99;
        $product->warranty = '2 года';
        $product->manufacturer_id = 10;
        $product->save();


        $product = new Product;
        $product->name = 'DW Collector\'s Series';
        $product->description = 'DW Collector\'s Series - это профессиональные барабаны, созданные для требовательных музыкантов. Они изготавливаются из высококачественных материалов с использованием передовых технологий и ручной работы. Барабаны DW Collector\'s Series предлагают широкий выбор конфигураций и размеров, а также различные отделки, позволяющие настроить инструмент под свои предпочтения и стиль игры. Они обладают отличной резонансной характеристикой, богатым и сбалансированным звучанием и высоким уровнем отзывчивости. Барабаны DW Collector\'s Series - это надежные и мощные инструменты, которые подойдут для любого профессионального музыканта и студийной работы.';
        $product->image = 'img31.png';
        $product->quantity = 5;
        $product->purchase_price = 84999.00;
        $product->selling_price = 99999.99;
        $product->warranty = '1 год';
        $product->manufacturer_id = 8;
        $product->save();

    }
}
