<?php

use Illuminate\Database\Seeder;
use App\Model\Permissao;

class PermissaosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permissao::create([
        'nome'=>'gerir_usuario',
      ]);
    }
}
