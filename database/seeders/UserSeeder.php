<?php

namespace Database\Seeders;

use App\Models\Cuentas;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Admin';
        $user->username = 'Admin';
        $user->cedula = '11111111';
        $user->phone = '11111111111';
        $user->nacimiento = '2025-12-12';
        $user->email = 'admin@admin.com';
        $user->role = 'admin';
        $user->password = bcrypt('111111111');
        $user->pregunta_1 = '1';
        $user->respuesta_1 = bcrypt('1');
        $user->pregunta_2 = '2';
        $user->respuesta_2 = bcrypt('2');
        $user->pregunta_3 = '3';
        $user->respuesta_3 = bcrypt('3');
        
        $user->save();

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000001';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '1';
        $cuenta->user_id = '1';
        $cuenta->save();
        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000002';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '2';
        $cuenta->user_id = '1';
        $cuenta->save();

        $user = new User();
        $user->name = 'Jose Mendoza';
        $user->username = '222';
        $user->cedula = '22222222';
        $user->phone = '22222222222';
        $user->nacimiento = '2025-12-12';
        $user->email = 'user@user.com';
        $user->role = 'mod';
        $user->password = bcrypt('222222222');
        $user->pregunta_1 = '1';
        $user->respuesta_1 = bcrypt('1');
        $user->pregunta_2 = '2';
        $user->respuesta_2 = bcrypt('2');
        $user->pregunta_3 = '3';
        $user->respuesta_3 = bcrypt('3');
        $user->save();

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000003';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '1';
        $cuenta->user_id = '2';
        $cuenta->save();
        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000004';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '2';
        $cuenta->user_id = '2';
        $cuenta->save();

        $user = new User();
        $user->name = 'Ana Gonzales';
        $user->username = '333';
        $user->cedula = '33333333';
        $user->phone = '33333333333';
        $user->nacimiento = '2025-12-12';
        $user->email = 'ana@gmail.com';
        $user->role = 'user';
        $user->password = bcrypt('333333333');
        $user->pregunta_1 = '1';
        $user->respuesta_1 = bcrypt('1');
        $user->pregunta_2 = '2';
        $user->respuesta_2 = bcrypt('2');
        $user->pregunta_3 = '3';
        $user->respuesta_3 = bcrypt('3');
        $user->save();

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000005';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '2';
        $cuenta->user_id = '3';
        $cuenta->save();

        $user = new User();
        $user->name = 'Ana Gonzales';
        $user->username = '444';
        $user->cedula = '44444444';
        $user->phone = '44444444444';
        $user->nacimiento = '2025-12-12';
        $user->email = '444@gmail.com';
        $user->role = 'user';
        $user->password = bcrypt('444444444');
        $user->pregunta_1 = '1';
        $user->respuesta_1 = bcrypt('1');
        $user->pregunta_2 = '2';
        $user->respuesta_2 = bcrypt('2');
        $user->pregunta_3 = '3';
        $user->respuesta_3 = bcrypt('3');
        $user->save();

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000006';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '2';
        $cuenta->user_id = 4;
        $cuenta->save();

        $user = new User();
        $user->name = 'Ana Gonzales';
        $user->username = '555';
        $user->cedula = '55555555';
        $user->phone = '555555555';
        $user->nacimiento = '2025-12-12';
        $user->email = '555@gmail.com';
        $user->role = 'user';
        $user->password = bcrypt('555');
        $user->pregunta_1 = '1';
        $user->respuesta_1 = bcrypt('1');
        $user->pregunta_2 = '2';
        $user->respuesta_2 = bcrypt('2');
        $user->pregunta_3 = '3';
        $user->respuesta_3 = bcrypt('3');
        $user->save();

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000007';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '2';
        $cuenta->user_id = '5';
        $cuenta->save();

        $user = new User();
        $user->name = 'Ana Gonzales';
        $user->username = '666';
        $user->cedula = '6';
        $user->phone = '6';
        $user->nacimiento = '2025-12-12';
        $user->email = '6@gmail.com';
        $user->role = 'user';
        $user->password = bcrypt('6');
        $user->pregunta_1 = '1';
        $user->respuesta_1 = bcrypt('1');
        $user->pregunta_2 = '2';
        $user->respuesta_2 = bcrypt('2');
        $user->pregunta_3 = '3';
        $user->respuesta_3 = bcrypt('3');
        $user->save();

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000008';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '2';
        $cuenta->user_id = '6';
        $cuenta->save();

        $user = new User();
        $user->name = 'Ana Gonzales';
        $user->username = '777';
        $user->cedula = '7';
        $user->phone = '7';
        $user->nacimiento = '2025-12-12';
        $user->email = '7@gmail.com';
        $user->role = 'user';
        $user->password = bcrypt('7');
        $user->pregunta_1 = '1';
        $user->respuesta_1 = bcrypt('1');
        $user->pregunta_2 = '2';
        $user->respuesta_2 = bcrypt('2');
        $user->pregunta_3 = '3';
        $user->respuesta_3 = bcrypt('3');
        $user->save();

        $tema = new Tema();
        $tema->sidebar = "#343a40";
        $tema->button_sidebar = "#007bff";
        $tema->text_color_sidebar = "#fff";
        $tema->background = "";
        $user->tema()->save($tema);

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000009';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '2';
        $cuenta->user_id = '7';
        $cuenta->save();

        $cuenta = new Cuentas();
        $cuenta->accountNumber = '9911000010';
        $cuenta->availableBalance = '200';
        $cuenta->cuentaType = '1';
        $cuenta->user_id = '7';
        $cuenta->save();
    }
}
