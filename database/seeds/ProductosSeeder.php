<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Producto Evertec 1',
            'price' => '20000'
        ]);

        DB::table('products')->insert([
            'name' => 'Producto Evertec 2',
            'price' => '25000'
        ]);
        DB::table('products')->insert([
            'name' => 'Producto Evertec 3',
            'price' => '28000'
        ]);
    }
}
