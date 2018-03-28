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

  //TODO profile update data
  Route::get('/dashboard/{name}/profile', 'ProfileController@index');
  Route::resource('/dashboard/{name}/profile','ProfileController');
  Route::post('/dashboard/{name}/profile_img','ProfileController@update_avatar');
  route::post('/dashboard/{name}/profile_edit', 'ProfileController@update');
  Route::get('/dashboard/{id}/profile', 'ProfileController@TotalFactura');//


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

  // REPORTS => Malache
  Route::get('/entradas/report_geral_entradas', ['as'=>'rg_entradas', 'uses'=>'EntradaController@reportGeralEntradas']);
  Route::get('/entradas/report_geral_entradas/teste{id}', ['as'=>'entrada_teste', 'uses'=>'EntradaController@entradaTeste']);
  Route::get('/fornecedores/report_geral_fornecedores', ['as'=>'rg_fornecedores', 'uses'=>'fornecedorController@reportGeralFornecedores']);
  Route::get('/clientes/report_geral_clientes', ['as'=>'rg_clientes', 'uses'=>'ClienteController@reportGeralCliente']);

  Route::get('/clientes/report_geral_clientes/pdf', ['as'=>'pdf_clientes', 'uses'=>'ClienteController@pdf']);// TODO --

  Route::get('/saidas/report_geral_saidas', ['as'=>'rg_saidas', 'uses'=>'SaidaController@reportGeralSaidas']);
  /*Route::get('/produtos/report_geral_produtos', ['as'=>'rg_produtos', 'uses'=>'produtoController@reportGeralProdutos']);*/
  Route::get('/cotacoes/report_geral_cotacoes', ['as'=>'rg_cotacoes', 'uses'=>'CotacaoController@reportGeralCotacoes']);

  // CRITERIOS DOS REPORTS PARA PRODUTOS => Malache
  Route::get('/produtos/report_geral/ajax', 'produtoController@listarTodos')->name('report_geral_produto');

  Route::get('/produtos/report_geral/listar_prod_categoria_ajax/{id}', 'produtoController@listarPorCategoria')->name('listar_prod_categoria_ajax');

  Route::get('/produtos/report_geral/listar_prod_fornecedor_ajax/{id}', 'produtoController@listarPorFornecedor')->name('listar_prod_fornecedor_ajax');

  // CADSTRAR FORNECEDOR FAZENDO o redirect()->back() => Malache
  Route::post('/fornecedores/fornecedor_salvar_rback', 'fornecedorController@storeRedirectBack')->name('fornecedor_salvar_rback');

  // CADSTRAR CATEGORIA FAZENDO o redirect()->back() => Malache
  Route::post('/categoria/categoria_salvar_rback', 'CategoriaController@storeRedirectBack')->name('categoria_salvar_rback');

  // CADSTRAR TIPO DE COTACAO FAZENDO o redirect()->back() => Malache
  Route::post('/tipo_cotacao/tipo_cotacao_salvar_rback', 'TipoCotacaoController@storeRedirectBack')->name('tipo_cotacao_salvar_rback');

  // CADSTRAR CLIENTE FAZENDO o redirect()->back() => Malache
  Route::post('/cliente/cliente_salvar_rback', 'ClienteController@storeRedirectBack')->name('cliente_salvar_rback');

  // CADASTRAR A COTACAO COM ajax => Malache
  Route::post('cotacao/cotacao_store', 'CotacaoController@store');
  Route::get('cotacao/index', 'CotacaoController@index');

  // CADASTRAR A SAIDA COM ajax => Malache
  // Route::post('saida/saida_store', 'SaidaController@store');
  // Route::get('saida/index', 'SaidaController@index');

  // SAIDAS, Privado, Publico, Concurso 
  Route::get('/saida/saida_pubblico_create/', 'SaidaController@saidaPublicoCreate')->name('saidaPublicoCreate');
  Route::get('/saida/saida_concurso_create/', 'SaidaController@saidaConcursoCreate')->name('saidaConcursoCreate');
  Route::post('/saida/concurso/dados', 'SaidaController@findConcursoDados')->name('findConcursoDados');

  // CRIAR GUIA DE ENTREGA => Malache
  Route::get('/guia_entrega/create_guia/{id}', 'GuiaEntregaController@createGuia')->name('create_guia');
  Route::get('/guia_entrega/show_guia_entrega/{id}', 'GuiaEntregaController@showGuiasEntrega')->name('show_guia_entrega');
<<<<<<< HEAD


  // GERIR PAGAMENTO DA SAIDA => Malache
  Route::post('/saida/pagamento', 'SaidaController@pagamentoSaida')->name('pagamentoSaida');
  Route::get('/saida/create_pagamento/{id}', 'SaidaController@createPagamentoSaida')->name('createPagamentoSaida');

=======
  Route::get('/guia_entrega/{id}/relatorio', ['as'=>'guiaRelatorio','uses'=>'GuiaEntregaController@showRelatorio']);//TODO --para imprimir as guias de entrega
>>>>>>> 34c6a2d985c8ecfdfb6672543921036f7023b184
  // GERIR PAGAMENTO DA VENDA => Malache
  Route::get('/venda/create_pagamento/{id}', 'VendaController@createPagamentoVenda')->name('createPagamentoVenda');
   Route::post('/venda/pagamento', 'VendaController@pagamentoVenda')->name('pagamentoVenda');

  // GERIR PAGAMENTO DO CONCURSO => Malache
  Route::get('/concurso/create_pagamento/{id}', 'ConcursoController@createPagamentoConcurso')->name('createPagamentoConcurso');
  Route::post('/concurso/pagamento', 'ConcursoController@pagamentoConcurso')->name('pagamentoConcurso');

  // GERIR PAGAMENTO DA ENTRADA => Malache
  Route::post('/entrada/pagamento', 'EntradaController@pagamentoEntrada')->name('pagamentoEntrada');




  //Rotas de operações
  Route::resource('/fornecedores', 'fornecedorController');
  Route::resource('/produtos', 'produtoController');
  Route::resource('/categoria', 'CategoriaController');
  Route::resource('/cliente', 'ClienteController');
  Route::resource('/tipo_cliente', 'TipoClienteController');

  Route::resource('/factura', 'FacturacaoController');


  Route::resource('/saida', 'SaidaController');
  Route::resource('/iten_saida', 'ItenSaidaController');
  Route::resource('/guia_entrega', 'GuiaEntregaController');
  Route::resource('/iten_guia_entrega', 'ItenGuiaEntregaController');
  Route::resource('/venda', 'VendaController');
  Route::resource('/iten_venda', 'ItenVendaController');
  Route::resource('/cotacao', 'CotacaoController');
  Route::resource('/cotacao/iten_cotacao', 'ItenCotacaoController');
  Route::resource('/tipo_cotacao', 'TipoCotacaoController');
  Route::resource('/entrada', 'EntradaController');
  Route::resource('/entrada/iten_entrada', 'ItenEntradaController');
  Route::resource('/concurso', 'ConcursoController');
  Route::resource('/iten_concurso', 'ItenConcursoController');



/*
  Route::group(['namespace' => 'Testes'], function(){
    Route::resource('/teste_categoria', 'CategoriaController');
    Route::resource('/teste_fornecedor', 'FornecedorController');
    Route::resource('/teste_cliente', 'ClienteController');
    Route::resource('/teste_role', 'RoleController');
    Route::resource('/teste_permissao', 'PermissaoController');
    Route::resource('/teste_saida', 'SaidaController');
    Route::resource('/teste_iten_saida', 'ItenSaidaController');

  });
 */

});
