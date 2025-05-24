<?php

namespace Database\Seeders;

use App\Models\Monedas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonedasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moneda = new Monedas();
        $moneda->moneda = "Fritos";
        $moneda->precio = 1;
        $moneda->reserva = 99999999;
        $moneda->save();

        $moneda = new Monedas();
        $moneda->moneda = "Dolar";
        $moneda->precio = 2.5;
        $moneda->reserva = 99999999;
        $moneda->save();
    }
}
