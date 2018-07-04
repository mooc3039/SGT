<?php

use Illuminate\Database\Seeder;
use App\Fornecedor;

class FornecedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Fornecedor::create([
        'nome'=>'META LTD',
        'endereco'=>'Av. Samuel Magaia',
        'contacto'=>'fax:214528',
        'email'=>'meta@gmail.com',
        'telefone'=>845280673,
      ]);
    }
}
