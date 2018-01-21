<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Role::insert([
        ['nome'=>'Administrador'],
        ['nome'=>'Receiptionist'],
        ['nome'=>'Manager'],
        ['nome'=>'CEO']

      ]);
    }
}
