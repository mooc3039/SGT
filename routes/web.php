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
  Route::get('/dashboard/inicio',['as'=>'paginainicial','uses'=>'DashboardController@paginaInicial']);
});

Route::group(['middleware'=>['authen','roles'],'roles'=>['Administrador']],function(){

  //para administrador


  Route::get('/gerir/stock',['as'=>'indexStock','uses'=>'paginasController@indexStock']);
//Rotas das views
  Route::get('/facturas/index',['as'=>'facturar','uses'=>'FacturarController@index']);
  Route::get('/facturas/preco', ['as'=>'findPrice','uses'=>'FacturarController@findPrice']);
  Route::post('/facturas/insert', ['as'=>'insert', 'uses'=>'FacturarController@insert']);

  Route::get('/gerir/usuario',['as'=>'indexUsuario','uses'=>'paginasController@indexUsuario']);
  Route::get('/gerir/cliente',['as'=>'indexCliente','uses'=>'paginasController@indexCliente']);

  //Rotas get para gerar impressao em formato pdf => Malache
  Route::get('/saida/pdf/{id}', ['as'=>'saida_pdf', 'uses'=>'SaidaController@report']);
  Route::get('/fornecedores/inactivos', ['as'=>'fornecedores_inactivos', 'uses'=>'fornecedorController@inactivos']);

  // Rotas para ACTIVAR e DESACTIVAR o Fornecedor => Malache
  Route::get('/fornecedores/activar/{id}', ['as'=>'fornecedores_activar', 'uses'=>'fornecedorController@activar']);
  Route::get('/fornecedores/desactivar/{id}', ['as'=>'fornecedores_desactivar', 'uses'=>'fornecedorController@desactivar']);

  // Rotas para Clientes ACTIVOS e para ACTIVAR e DESACTIVAR o Cliente => Malache
  Route::get('/clientes/inactivos', ['as'=>'clientes_inactivos', 'uses'=>'ClienteController@inactivos']);
  Route::get('/clientes/activar/{id}', ['as'=>'clientes_activar', 'uses'=>'ClienteController@activar']);
  Route::get('/clientes/desactivar/{id}', ['as'=>'clientes_desactivar', 'uses'=>'ClienteController@desactivar']);

  // REPORTS
  Route::get('/entradas/report_geral_entradas', ['as'=>'rg_entradas', 'uses'=>'EntradaController@reportGeralEntradas']);
  Route::get('/fornecedores/report_geral_fornecedores', ['as'=>'rg_fornecedores', 'uses'=>'fornecedorController@reportGeralFornecedores']);
  Route::get('/clientes/report_geral_clientes', ['as'=>'rg_clientes', 'uses'=>'ClienteController@reportGeralCliente']);
  Route::get('/saidas/report_geral_saidas', ['as'=>'rg_saidas', 'uses'=>'SaidaController@reportGeralSaidas']);
  Route::get('/produtos/report_geral_produtos', ['as'=>'rg_produtos', 'uses'=>'produtoController@reportGeralProdutos']);
  Route::get('/cotacoes/report_geral_cotacoes', ['as'=>'rg_cotacoes', 'uses'=>'CotacaoController@reportGeralCotacoes']);

  //Rotas de operações
  Route::resource('/fornecedores', 'fornecedorController');
  Route::resource('/produtos', 'produtoController');
  Route::resource('/cliente', 'ClienteController');
  Route::resource('/saida', 'SaidaController');
  Route::resource('/cotacao', 'CotacaoController');
  Route::resource('/entrada', 'EntradaController');
  

  Route::group(['namespace' => 'Testes'], function(){
    Route::resource('/teste_categoria', 'CategoriaController');
    Route::resource('/teste_fornecedor', 'FornecedorController');
    Route::resource('/teste_cliente', 'ClienteController');
    Route::resource('/teste_role', 'RoleController');
    Route::resource('/teste_permissao', 'PermissaoController');
    Route::resource('/teste_saida', 'SaidaController');
    Route::resource('/teste_iten_saida', 'ItenSaidaController');

  });


});
