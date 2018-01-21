<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',['as'=>'/','uses'=>'LoginController@getLogin']);
Route::post('/login',['as'=>'login','uses'=>'LoginController@postLogin']);

Route::get('/noPermission',function(){
  return view('layouts.permission.noPermission');
});


Route::group(['middleware'=>['authen']],function(){
  Route::get('/logout',['as'=>'logout','uses'=>'LoginController@getLogout']);
  Route::get('/dashboard',['as'=>'dashboard','uses'=>'DashboardController@dashboard']);
});

Route::group(['middleware'=>['authen','roles'],'roles'=>['administrador']],function(){
  //para administrador

  Route::get('/gerir/factura',['as'=>'indexFacturas','uses'=>'paginasController@indexFacturacao']);
  Route::get('/gerir/stock',['as'=>'indexStock','uses'=>'paginasController@indexStock']);
//Rotas das views
  Route::get('/facturas/index',['as'=>'facturar','uses'=>'FacturarController@index']);

  Route::get('/gerir/usuario',['as'=>'indexUsuario','uses'=>'paginasController@indexUsuario']);
  Route::get('/gerir/cliente',['as'=>'indexCliente','uses'=>'paginasController@indexCliente']);

  //Rotas de operações
  Route::resource('/fornecedores', 'fornecedorController');
  Route::resource('/produtos', 'produtoController');


});
