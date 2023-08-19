<?php

namespace App\Models;

use App\Http\Controllers\MainController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $guarded = ['id'];

    static public function search($query) {
        return Supplier::select()->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->orWhere('phone', 'LIKE', '%' . $query . '%')
            ->orderBy('name', 'ASC');
    }

    static public function storeOrUpdate($request, $supplier = null)
    {
        if (is_null($supplier)) {
            $supplier = new Supplier;
        }
        $supplier->fill($request->all());
        $supplier->name = MainController::capitalizeFirstWord($request->name);
        $supplier->save();
        return $supplier;
    }
    static public function makeDefault() {
        $supplier1 = new Supplier();
        $supplier1->name = 'Музыкальный мир';
        $supplier1->email = 'musmir@example.com';
        $supplier1->country = 'Россия';
        $supplier1->region = 'Московская область';
        $supplier1->city = 'Москва';
        $supplier1->street = 'ул. Ленина';
        $supplier1->house = '12';
        $supplier1->post_index = '123456';
        $supplier1->last_name = 'Иванов';
        $supplier1->first_name = 'Петр';
        $supplier1->third_name = 'Юрьевич';
        $supplier1->phone = '8(495)555-55-55';
        $supplier1->save();

        $supplier2 = new Supplier();
        $supplier2->name = 'Музыкальные инструменты';
        $supplier2->email = 'musinstr@example.com';
        $supplier2->country = 'Россия';
        $supplier2->region = 'Московская область';
        $supplier2->city = 'Химки';
        $supplier2->street = 'ул. Мира';
        $supplier2->house = '5';
        $supplier2->post_index = '141402';
        $supplier2->last_name = 'Петров';
        $supplier2->first_name = 'Иван';
        $supplier2->third_name = 'Сергеевич';
        $supplier2->phone = '8(495)666-66-66';
        $supplier2->save();

        $supplier3 = new Supplier();
        $supplier3->name = 'Музыкальные новинки';
        $supplier3->email = 'musnov@example.com';
        $supplier3->country = 'Россия';
        $supplier3->region = 'Санкт-Петербург';
        $supplier3->city = 'Санкт-Петербург';
        $supplier3->street = 'ул. Невский проспект';
        $supplier3->house = '21';
        $supplier3->post_index = '190000';
        $supplier3->last_name = 'Сидоров';
        $supplier3->first_name = 'Александр';
        $supplier3->phone = '8(812)777-77-77';
        $supplier3->save();

        $supplier4 = new Supplier();
        $supplier4->name = 'Гитарный мир';
        $supplier4->email = 'guitarworld@example.com';
        $supplier4->country = 'Россия';
        $supplier4->region = 'Краснодарский край';
        $supplier4->city = 'Краснодар';
        $supplier4->street = 'ул. Гитарная';
        $supplier4->house = '1';
        $supplier4->post_index = '350000';
        $supplier4->last_name = 'Попов';
        $supplier4->first_name = 'Николай';
        $supplier1->third_name = 'Евгеньевич';
        $supplier4->phone = '8(861)444-44-44';
        $supplier4->save();

        $supplier1 = new Supplier();
        $supplier1->name = 'Музыкальный магазин "Note"';
        $supplier1->email = 'note_music_shop@example.com';
        $supplier1->country = 'Россия';
        $supplier1->region = 'Московская область';
        $supplier1->city = 'Химки';
        $supplier1->street = 'ул. Кирова';
        $supplier1->house = 'д. 10';
        $supplier1->post_index = '141407';
        $supplier1->last_name = 'Петров';
        $supplier1->first_name = 'Андрей';
        $supplier1->phone = '+7(495)123-45-67';
        $supplier1->save();

        $supplier2 = new Supplier();
        $supplier2->name = 'Музыкальный магазин "Aria"';
        $supplier2->email = 'aria_music_shop@example.com';
        $supplier2->country = 'Россия';
        $supplier2->region = 'Ленинградская область';
        $supplier2->city = 'Санкт-Петербург';
        $supplier2->street = 'ул. Ломоносова';
        $supplier2->house = 'д. 25';
        $supplier2->post_index = '191002';
        $supplier2->last_name = 'Иванов';
        $supplier2->first_name = 'Александр';
        $supplier2->third_name = 'Андреевич';
        $supplier2->phone = '+7(812)123-45-67';
        $supplier2->save();

        $supplier3 = new Supplier();
        $supplier3->name = 'Музыкальный магазин "Musica"';
        $supplier3->email = 'musica_music_shop@example.com';
        $supplier3->country = 'Россия';
        $supplier3->region = 'Московская область';
        $supplier3->city = 'Мытищи';
        $supplier3->street = 'ул. Первомайская';
        $supplier3->house = 'д. 5';
        $supplier3->post_index = '141008';
        $supplier3->last_name = 'Сидоров';
        $supplier3->first_name = 'Игорь';
        $supplier3->phone = '+7(495)123-45-66';
        $supplier3->save();

        $supplier4 = new Supplier();
        $supplier4->name = 'Музыкальный магазин "Harmony"';
        $supplier4->email = 'harmony_music_shop@example.com';
        $supplier4->country = 'Россия';
        $supplier4->region = 'Московская область';
        $supplier4->city = 'Москва';
        $supplier4->street = 'ул. Ленина';
        $supplier4->house = 'д. 15';
        $supplier4->post_index = '115184';
        $supplier4->last_name = 'Козлов';
        $supplier4->first_name = 'Дмитрий';
        $supplier4->third_name = 'Игоревич';
        $supplier4->phone = '+7(495)123-45-65';
        $supplier4->save();

        $supplier1 = new Supplier();
        $supplier1->name = 'ООО "Музыкальные Инструменты"';
        $supplier1->email = 'musical_instruments@example.com';
        $supplier1->country = 'Россия';
        $supplier1->region = 'Московская область';
        $supplier1->city = 'Красногорск';
        $supplier1->street = 'ул. Ленина';
        $supplier1->house = 'д. 15';
        $supplier1->post_index = '143403';
        $supplier1->last_name = 'Иванов';
        $supplier1->first_name = 'Андрей';
        $supplier1->phone = '+7(495)123-45-12';
        $supplier1->save();

        $supplier2 = new Supplier();
        $supplier2->name = 'Магазин гитар "6 струн"';
        $supplier2->email = '6strings@example.com';
        $supplier2->country = 'Россия';
        $supplier2->region = 'Московская область';
        $supplier2->city = 'Москва';
        $supplier2->street = 'ул. Большая Дмитровка';
        $supplier2->house = 'д. 12/5';
        $supplier2->post_index = '125009';
        $supplier2->last_name = 'Петров';
        $supplier2->first_name = 'Дмитрий';
        $supplier2->phone = '+7(495)456-78-90';
        $supplier2->save();

        $supplier3 = new Supplier();
        $supplier3->name = 'Музыкальная планета';
        $supplier3->email = 'musical_planet@example.com';
        $supplier3->country = 'Россия';
        $supplier3->region = 'Краснодарский край';
        $supplier3->city = 'Сочи';
        $supplier3->street = 'ул. Ленина';
        $supplier3->house = 'д. 100';
        $supplier3->post_index = '354000';
        $supplier3->last_name = 'Николаев';
        $supplier3->first_name = 'Артем';
        $supplier3->phone = '+7(862)123-45-67';
        $supplier3->save();

        $supplier4 = new Supplier();
        $supplier4->name = 'ООО "Музыкальная комната"';
        $supplier4->email = 'music_room@example.com';
        $supplier4->country = 'Россия';
        $supplier4->region = 'Новосибирская область';
        $supplier4->city = 'Новосибирск';
        $supplier4->street = 'ул. Ленина';
        $supplier4->house = 'д. 20';
        $supplier4->post_index = '630000';
        $supplier4->last_name = 'Сидоров';
        $supplier4->first_name = 'Алексей';
        $supplier4->phone = '+7(383)123-45-67';
        $supplier4->save();

        $supplier4 = new Supplier();
        $supplier4->name = 'ООО "Музыкмлити"';
        $supplier4->email = 'musicality@example.com';
        $supplier4->country = 'Россия';
        $supplier4->region = 'Тюменская область';
        $supplier4->city = 'Ишим';
        $supplier4->street = 'ул. Ленина';
        $supplier4->house = 'д. 22';
        $supplier4->post_index = '630000';
        $supplier4->last_name = 'Сидоров';
        $supplier4->first_name = 'Алексей';
        $supplier4->phone = '+7(983)912-43-67';
        $supplier4->save();

        $supplier1 = new Supplier();
        $supplier1->name = 'Музыкальный магазин "Аккорд"';
        $supplier1->email = 'accord@example.com';
        $supplier1->country = 'Россия';
        $supplier1->region = 'Московская область';
        $supplier1->city = 'Москва';
        $supplier1->street = 'ул. Ленина';
        $supplier1->house = '12';
        $supplier1->post_index = '123456';
        $supplier1->last_name = 'Иванов';
        $supplier1->first_name = 'Петр';
        $supplier1->third_name = 'Юрьевич';
        $supplier1->phone = '8(495)555-33-11';
        $supplier1->save();

        $supplier2 = new Supplier();
        $supplier2->name = 'Магазин музыкальных инструментов "Мелодия"';
        $supplier2->email = 'melody@example.com';
        $supplier2->country = 'Россия';
        $supplier2->region = 'Санкт-Петербург';
        $supplier2->city = 'Санкт-Петербург';
        $supplier2->street = 'ул. Невского проспекта';
        $supplier2->house = '21';
        $supplier2->post_index = '190000';
        $supplier2->last_name = 'Петров';
        $supplier2->first_name = 'Иван';
        $supplier2->third_name = 'Сергеевич';
        $supplier2->phone = '8(812)666-16-67';
        $supplier2->save();

        $supplier3 = new Supplier();
        $supplier3->name = 'Музыкальный центр "Созвучие"';
        $supplier3->email = 'consonance@example.com';
        $supplier3->country = 'Россия';
        $supplier3->region = 'Краснодарский край';
        $supplier3->city = 'Краснодар';
        $supplier3->street = 'ул. Гитарная';
        $supplier3->house = '1';
        $supplier3->post_index = '350000';
        $supplier3->last_name = 'Сидоров';
        $supplier3->first_name = 'Александр';
        $supplier3->phone = '8(861)957-72-77';
        $supplier3->save();

        $supplier4 = new Supplier();
        $supplier4->name = 'Музыкальный магазин "Гамма"';
        $supplier4->email = 'gamma@example.com';
        $supplier4->country = 'Россия';
        $supplier4->region = 'Московская область';
        $supplier4->city = 'Химки';
        $supplier4->street = 'ул. Кирова';
        $supplier4->house = '10';
        $supplier4->post_index = '141407';
        $supplier4->last_name = 'Козлов';
        $supplier4->first_name = 'Дмитрий';
        $supplier4->phone = '+7(495)227-45-87';
        $supplier4->save();

        $supplier5 = new Supplier();
        $supplier5->name = 'Музыкальный магазин "Гармония"';
        $supplier5->email = 'harmony@example.com';
        $supplier5->country = 'Россия';
        $supplier5->region = 'Самарская область';
        $supplier5->city = 'Самара';
        $supplier5->street = 'пр. Кирова';
        $supplier5->house = '45';
        $supplier5->post_index = '443001';
        $supplier5->last_name = 'Васильев';
        $supplier5->first_name = 'Андрей';
        $supplier5->phone = '+7(846)987-99-13';
        $supplier5->save();

        $supplier6 = new Supplier();
        $supplier6->name = 'Магазин музыкальных инструментов "Артист"';
        $supplier6->email = 'artist@example.com';
        $supplier6->country = 'Россия';
        $supplier6->region = 'Новосибирская область';
        $supplier6->city = 'Новосибирск';
        $supplier6->street = 'ул. Ленинградская';
        $supplier6->house = '30';
        $supplier6->post_index = '630000';
        $supplier6->last_name = 'Крылов';
        $supplier6->first_name = 'Михаил';
        $supplier6->third_name = 'Иванович';
        $supplier6->phone = '+7(383)555-15-04';
        $supplier6->save();

        $supplier7 = new Supplier();
        $supplier7->name = 'Музыкальный магазин "Альфа"';
        $supplier7->email = 'alpha@example.com';
        $supplier7->country = 'Россия';
        $supplier7->region = 'Тюменская область';
        $supplier7->city = 'Тюмень';
        $supplier7->street = 'пр. Гагарина';
        $supplier7->house = '18';
        $supplier7->post_index = '625000';
        $supplier7->last_name = 'Смирнов';
        $supplier7->first_name = 'Алексей';
        $supplier7->phone = '+7(345)157-58-06';
        $supplier7->save();

    }
}
