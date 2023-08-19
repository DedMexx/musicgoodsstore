<?php

namespace App\Models;

use App\Http\Controllers\MainController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $guarded = ['id'];

    static public function search($query) {
        return Client::select()
            ->whereRaw("CONCAT(last_name, ' ', first_name, ' ', third_name) LIKE '%".$query."%'")
            ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE '%".$query."%'")
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->orWhere('phone', 'LIKE', '%' . $query . '%')
            ->orderBy('last_name', 'ASC');
    }

    static public function storeOrUpdate($request, $client = null)
    {
        if (is_null($client)) {
            $client = new Client;
        }
        $client->fill($request->all());
        $client->save();
    }

    static public function makeDefault() {
        $client = new Client;
        $client->last_name = 'Иванов';
        $client->first_name = 'Петр';
        $client->third_name = 'Сергеевич';
        $client->phone = '+7(999)123-45-67';
        $client->email = 'ivanov.petr@example.com';
        $client->country = 'Россия';
        $client->region = 'Московская область';
        $client->city = 'Москва';
        $client->street = 'Улица Ленина';
        $client->house = '12';
        $client->post_index = '123456';
        $client->save();

        $client = new Client;
        $client->last_name = 'Кузнецов';
        $client->first_name = 'Дмитрий';
        $client->third_name = 'Иванович';
        $client->phone = '+7(916)789-01-23';
        $client->email = 'kuznetsov.dmitriy@example.com';
        $client->country = 'Россия';
        $client->region = 'Санкт-Петербург';
        $client->city = 'Санкт-Петербург';
        $client->street = 'Улица Невская';
        $client->house = '10';
        $client->post_index = '190000';
        $client->save();

        $client = new Client;
        $client->last_name = 'Петров';
        $client->first_name = 'Сергей';
        $client->phone = '+7(903)234-56-78';
        $client->email = 'petrov.sergey@example.com';
        $client->country = 'Россия';
        $client->region = 'Московская область';
        $client->city = 'Химки';
        $client->street = 'Улица Комсомольская';
        $client->house = '2';
        $client->post_index = '141401';
        $client->save();

        $client = new Client;
        $client->last_name = 'Васильев';
        $client->first_name = 'Иван';
        $client->third_name = 'Федорович';
        $client->phone = '+7(905)678-12-34';
        $client->email = 'vasilyev.ivan@example.com';
        $client->country = 'Россия';
        $client->region = 'Ростовская область';
        $client->city = 'Ростов-на-Дону';
        $client->street = 'Улица Большая Садовая';
        $client->house = '3';
        $client->post_index = '344002';
        $client->save();

        $client = new Client;
        $client->last_name = 'Соколов';
        $client->first_name = 'Александр';
        $client->third_name = 'Михайлович';
        $client->phone = '+7(925)890-12-34';
        $client->email = 'sokolov.alexandr@example.com';
        $client->country = 'Россия';
        $client->region = 'Московская область';
        $client->city = 'Мытищи';
        $client->street = 'Улица Шоссейная';
        $client->house = '7';
        $client->post_index = '141014';
        $client->save();

        $client = new Client;
        $client->last_name = 'Михайлов';
        $client->first_name = 'Максим';
        $client->phone = '+7(909)345-67-89';
        $client->email = 'mikhailov.maxim@example.com';
        $client->country = 'Россия';
        $client->region = 'Свердловская область';
        $client->city = 'Екатеринбург';
        $client->street = 'Улица Ленина';
        $client->house = '15';
        $client->post_index = '620014';
        $client->save();

        $client = new Client;
        $client->last_name = 'Иванов';
        $client->first_name = 'Анатолий';
        $client->third_name = 'Петрович';
        $client->phone = '+7(926)234-56-78';
        $client->email = 'ivanov.anatoliy@example.com';
        $client->country = 'Россия';
        $client->region = 'Краснодарский край';
        $client->city = 'Сочи';
        $client->street = 'Улица Ленина';
        $client->house = '22';
        $client->post_index = '354000';
        $client->save();

        $client = new Client;
        $client->last_name = 'Горбачев';
        $client->first_name = 'Михаил';
        $client->third_name = 'Сергеевич';
        $client->phone = '+7(909)123-45-67';
        $client->email = 'gorbachev.mikhail@example.com';
        $client->country = 'Россия';
        $client->region = 'Московская область';
        $client->city = 'Пушкино';
        $client->street = 'Улица Центральная';
        $client->house = '3';
        $client->post_index = '141206';
        $client->save();

        $client = new Client;
        $client->last_name = 'Ковалев';
        $client->first_name = 'Игорь';
        $client->third_name = 'Геннадьевич';
        $client->phone = '+7(916)345-67-89';
        $client->email = 'kovalev.igor@example.com';
        $client->country = 'Россия';
        $client->region = 'Московская область';
        $client->city = 'Жуковский';
        $client->street = 'Улица Мира';
        $client->house = '15';
        $client->post_index = '140180';
        $client->save();

        $client = new Client;
        $client->last_name = 'Новиков';
        $client->first_name = 'Денис';
        $client->third_name = 'Игоревич';
        $client->phone = '+7(925)456-78-90';
        $client->email = 'novikov.denis@example.com';
        $client->country = 'Россия';
        $client->region = 'Московская область';
        $client->city = 'Королев';
        $client->street = 'Улица Советская';
        $client->house = '7';
        $client->post_index = '141070';
        $client->save();

        $client = new Client;
        $client->last_name = 'Тимофеев';
        $client->first_name = 'Владимир';
        $client->third_name = 'Александрович';
        $client->phone = '+7(903)345-67-89';
        $client->email = 'timofeev.vladimir@example.com';
        $client->country = 'Россия';
        $client->region = 'Московская область';
        $client->city = 'Долгопрудный';
        $client->street = 'Улица Гагарина';
        $client->house = '3';
        $client->post_index = '141701';
        $client->save();

    }
}
