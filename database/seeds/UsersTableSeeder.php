<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      User::create([
        'role_id'=>1,
        'active'=>1,
        'name'=>'Osorio Cassiano Malache',
        'username'=>'osoriocassiano',
        'email'=>'osoriocassiano@gmail.com',
        'password'=>bcrypt('123456'),
        'remember_token'=> str_random(10),
      ]);

      User::create([
        'role_id'=>1,
        'active'=>1,
        'name'=>'Carlos Manhique',
        'username'=>'carlosmanhique',
        'email'=>'carlosmanhique@gmail.com',
        'password'=>bcrypt('123456'),
        'remember_token'=> str_random(10),
      ]);

      User::create([
        'role_id'=>2,
        'active'=>1,
        'name'=>'Ossmane Dos Prazeres',
        'username'=>'ossmane',
        'email'=>'ossmane@gmail.com',
        'password'=>bcrypt('123456'),
        'remember_token'=> str_random(10),
      ]);
    }
}
