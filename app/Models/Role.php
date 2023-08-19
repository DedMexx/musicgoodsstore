<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    static public function makeDefault() {
        $role = new Role;
        $role->name = 'Директор';
        $role->save();

        $role = new Role;
        $role->name = 'Бухгалтер';
        $role->save();

        $role = new Role;
        $role->name = 'Работник торгового зала';
        $role->save();

        $role = new Role;
        $role->name = 'Работник склада';
        $role->save();

        $role = new Role;
        $role->name = 'Менедежер по маркетингу';
        $role->save();
    }
}
