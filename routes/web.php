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

  Route::get('/produto/find', ['as'=>'findPrice','uses'=>'ProdutoController@findPrice']);
  // Route::get('/facturas/preco', ['as'=>'findPrice','uses'=>'FacturacaoController@findPrice']);


  //======================= Profile ============================
  //TODO profile update data
  Route::get('/dashboard/{name}/profile', 'ProfileController@index');
  Route::resource('/dashboard/{name}/profile','ProfileController');
  Route::post('/dashboard/{name}/profile_img','ProfileController@update_avatar');
  route::post('/dashboard/{name}/profile_edit', 'ProfileController@update');
  Route::get('/dashboard/{id}/profile', 'ProfileController@TotalFactura');//
  //======================= FIM Profile ============================

  //======================= Entrada ============================
  // GERIR PAGAMENTO DA ENTRADA => Malache
  Route::post('/entrada/pagamento', 'EntradaController@pagamentoEntrada')->name('pagamentoEntrada');
  Route::get('/entrada/create_pagamento/{id}', 'EntradaController@createPagamentoEntrada')->name('createPagamentoEntrada');
  //Relatorios Gerais das Entradas
  Route::get('/entrada/report_geral_entradas', ['as'=>'rg_entradas', 'uses'=>'EntradaController@reportGeralEntradas']);
  Route::post('/entrada/report_geral/listar_entrada_mes', 'EntradaController@listarEntradaPorMes')->name('listar_entrada_mes');
  Route::post('/entrada/report_geral/listar_entrada_ano', 'EntradaController@listarEntradaPorAno')->name('listar_entrada_ano');
  // Impressao Entrada
  Route::get('/entrada/{id}/relatorio', ['as'=>'entradaRelatorio','uses'=>'EntradaController@showRelatorio']);
  //======================= FIM Entrada ============================

  //======================= Venda ============================
  // GERIR PAGAMENTO DA VENDA => Malache
  Route::post('/venda/pagamento', 'VendaController@pagamentoVenda')->name('pagamentoVenda');
  Route::get('/venda/create_pagamento/{id}', 'VendaController@createPagamentoVenda')->name('createPagamentoVenda');
  // Relatorios Gerais da Vendas
  Route::get('/venda/report_geral_vendas', ['as'=>'rg_vendas', 'uses'=>'VendaController@reportGeralVendas']);
  Route::post('/venda/report_geral/listar_vend_mes', 'VendaController@listarVendaPorMes')->name('listar_vend_mes');
  Route::post('/venda/report_geral/listar_vend_ano', 'VendaController@listarVendaPorAno')->name('listar_vend_ano');
  // Impressao Venda
  Route::get('/venda/{id}/relatorio', ['as'=>'vendaRelatorio','uses'=>'VendaController@showRelatorio']);
  // EDITAR O MODTIVO JUSTIFICATIVO DA NAO APLICACAO DO IMPOSTO
  Route::post('/venda/editar_motivo_justificativo_imposto', 'VendaController@motivoNaoAplicacaoImposto')->name('editar_motivo_venda');
  //======================= FIM Venda ============================

  //======================= Saida ============================
  // GERIR PAGAMENTO DA SAIDA => Malache
  Route::post('/saida/pagamento', 'SaidaController@pagamentoSaida')->name('pagamentoSaida');
  Route::get('/saida/create_pagamento/{id}', 'SaidaController@createPagamentoSaida')->name('createPagamentoSaida');
   // SAIDAS, Privado, Publico, Concurso
  Route::get('/saida/saida_pubblico_create/', 'SaidaController@saidaPublicoCreate')->name('saidaPublicoCreate');
  Route::get('/saida/saida_concurso_create/', 'SaidaController@saidaConcursoCreate')->name('saidaConcursoCreate');
  Route::post('/saida/concurso/dados', 'SaidaController@findConcursoDados')->name('findConcursoDados');
  // Impressao das Saidas
  Route::get('/saida/{id}/relatorio', ['as'=>'saidaRelatorio','uses'=>'SaidaController@showRelatorio']);
  //Rotas get para gerar impressao em formato pdf => Malache
  Route::get('/saida/pdf/{id}', ['as'=>'saida_pdf', 'uses'=>'SaidaController@report']);
  // EDITAR O MODTIVO JUSTIFICATIVO DA NAO APLICACAO DO IMPOSTO
  Route::post('/saida/editar_motivo_justificativo_imposto', 'SaidaController@motivoNaoAplicacaoImposto')->name('editar_motivo_saida');
  //======================= FIM Saida ============================

  //======================= Concurso ============================
  // Relatorios Gerais dos Concursos
  Route::get('/concurso/report_geral_concursos', ['as'=>'rg_concursos', 'uses'=>'ConcursoController@reportGeralConcursos']);
  Route::post('/concurso/report_geral/listar_concurso_mes', 'ConcursoController@listarConcursoPorMes')->name('listar_concurso_mes');
  Route::post('/concurso/report_geral/listar_concurso_ano', 'ConcursoController@listarConcursoPorAno')->name('listar_concurso_ano');
  // GERIR PAGAMENTO DO CONCURSO => Malache
  Route::get('/concurso/create_pagamento/{id}', 'ConcursoController@createPagamentoConcurso')->name('createPagamentoConcurso');
  Route::post('/concurso/pagamento', 'ConcursoController@pagamentoConcurso')->name('pagamentoConcurso');
  Route::get('/concurso/{id}/relatorio', ['as'=>'concursoRelatorio','uses'=>'ConcursoController@showRelatorio']);
  // FACTURAS DO CONCURSO
  Route::get('/concurso/facturas_concurso/{id}', 'ConcursoController@facturasConcurso')->name('facturasConcurso');
  // EDITAR O MODTIVO JUSTIFICATIVO DA NAO APLICACAO DO IMPOSTO
  Route::post('/concurso/editar_motivo_justificativo_imposto', 'ConcursoController@motivoNaoAplicacaoImposto')->name('editar_motivo_concurso');
  //======================= FIM Concurso ============================

  //======================= Cotacao ============================
  // CADASTRAR A COTACAO COM ajax => Malache
  Route::post('cotacao/cotacao_store', 'CotacaoController@store');
  Route::get('cotacao/index', 'CotacaoController@index');
  Route::get('cotaca/dados', 'CotacaoController@get_datatable');
  // Impressao da Cotacao
  Route::get('/cotacao/{id}/relatorio', ['as'=>'cotacaoRelatorio','uses'=>'CotacaoController@showRelatorio']);
  //======================= FIM Cotacao ============================

  //======================= Guia de Entrega ============================
  // CRIAR GUIA DE ENTREGA => Malache
  Route::get('/guia_entrega/create_guia/{id}', 'GuiaEntregaController@createGuia')->name('create_guia');
  Route::get('/guia_entrega/show_guia_entrega/{id}', 'GuiaEntregaController@showGuiasEntrega')->name('show_guia_entrega');
  //RELATORIOS
  Route::get('/guia_entrega/{id}/relatorio', ['as'=>'guiaRelatorio','uses'=>'GuiaEntregaController@showRelatorio']);//TODO --para imprimir as guias de entrega
  //======================= FIM Guia de Entrega ============================


  Route::resource('/entrada', 'EntradaController');
  Route::resource('/entrada/iten_entrada', 'ItenEntradaController');
  Route::resource('/concurso', 'ConcursoController');
  Route::resource('/iten_concurso', 'ItenConcursoController');
  Route::resource('/venda', 'VendaController');
  Route::resource('/iten_venda', 'ItenVendaController');
  Route::resource('/saida', 'SaidaController');
  Route::resource('/iten_saida', 'ItenSaidaController');
  Route::resource('/guia_entrega', 'GuiaEntregaController');
  Route::resource('/iten_guia_entrega', 'ItenGuiaEntregaController');
  Route::resource('/cotacao', 'CotacaoController');
  Route::resource('/cotacao/iten_cotacao', 'ItenCotacaoController');



});

Route::group(['middleware'=>['authen','roles'],'roles'=>['Administrador']],function(){


  // CADSTRAR CATEGORIA FAZENDO o redirect()->back() => Malache
  Route::post('/categoria/categoria_salvar_rback', 'CategoriaController@storeRedirectBack')->name('categoria_salvar_rback');

  //======================= Fornecedor ============================
  // Rotas para ACTIVAR e DESACTIVAR o Fornecedor => Malache
  Route::get('/fornecedores/activar/{id}', ['as'=>'fornecedores_activar', 'uses'=>'fornecedorController@activar']);
  Route::get('/fornecedores/desactivar/{id}', ['as'=>'fornecedores_desactivar', 'uses'=>'fornecedorController@desactivar']);
  Route::get('/fornecedores/report_geral_fornecedores', ['as'=>'rg_fornecedores', 'uses'=>'fornecedorController@reportGeralFornecedores']);
   // CADSTRAR FORNECEDOR FAZENDO o redirect()->back() => Malache
  Route::post('/fornecedores/fornecedor_salvar_rback', 'fornecedorController@storeRedirectBack')->name('fornecedor_salvar_rback');
  Route::get('/fornecedores/inactivos', ['as'=>'fornecedores_inactivos', 'uses'=>'fornecedorController@inactivos']);
  //======================= FIM Fornecedor ============================

  //======================= Cliente ============================
  // Clientes
  Route::get('/clientes/report_geral_clientes', ['as'=>'rg_clientes', 'uses'=>'ClienteController@reportGeralCliente']);
  Route::get('/clientes/cliente_privado', ['as'=>'cliente_privado', 'uses'=>'ClienteController@indexClientePrivado']);
  Route::get('/clientes/cliente_publico', ['as'=>'cliente_publico', 'uses'=>'ClienteController@indexClientePublico']);

  Route::get('/clientes/report_geral_clientes/pdf', ['as'=>'pdf_clientes', 'uses'=>'ClienteController@pdf']);
  // Rotas para Clientes ACTIVOS e para ACTIVAR e DESACTIVAR o Cliente => Malache
  Route::get('/clientes/inactivos', ['as'=>'clientes_inactivos', 'uses'=>'ClienteController@inactivos']);
  Route::get('/clientes/activar/{id}', ['as'=>'clientes_activar', 'uses'=>'ClienteController@activar']);
  Route::get('/clientes/desactivar/{id}', ['as'=>'clientes_desactivar', 'uses'=>'ClienteController@desactivar']);
  // CADSTRAR CLIENTE FAZENDO o redirect()->back() => Malache
  Route::post('/cliente/cliente_salvar_rback', 'ClienteController@storeRedirectBack')->name('cliente_salvar_rback');

  //======================= FIM Cliente ============================

  //======================= Produto ============================
  // CRITERIOS DOS REPORTS PARA PRODUTOS => Malache
  Route::get('/produtos/report_geral/ajax', 'produtoController@listarTodos')->name('report_geral_produto');

  Route::get('/produtos/report_geral/listar_prod_categoria_ajax/{id}', 'produtoController@listarPorCategoria')->name('listar_prod_categoria_ajax');

  Route::get('/produtos/report_geral/listar_prod_fornecedor_ajax/{id}', 'produtoController@listarPorFornecedor')->name('listar_prod_fornecedor_ajax');
  /*Route::get('/produtos/report_geral_produtos', ['as'=>'rg_produtos', 'uses'=>'produtoController@reportGeralProdutos']);*/
  //======================= FIM Produto ============================

  //======================= Usuario ============================
  //para administrador
  Route::get('/usuarios/inactivos', ['as'=>'usuarios_inactivos', 'uses'=>'UsuarioController@inactivos']);
  Route::get('/usuarios/activar/{id}', ['as'=>'usuarios_activar', 'uses'=>'UsuarioController@activar']);
  Route::get('/usuarios/desactivar/{id}', ['as'=>'usuarios_desactivar', 'uses'=>'UsuarioController@desactivar']);
  Route::get('/usuarios/lista', ['as'=>'indexUsuario','uses'=>'UsuarioController@index']);
  //======================= FIM Usuario ============================

  //======================= Saida (resource acima) ============================
  // Relatorios Gerais das Saidas
  Route::get('/saidas/report_geral_saidas', ['as'=>'rg_saidas', 'uses'=>'SaidaController@reportGeralSaidas']);
  Route::post('/saida/report_geral/listar_saida_mes', 'SaidaController@listarSaidaPorMes')->name('listar_saida_mes');
  Route::post('/saida/report_geral/listar_saida_ano', 'SaidaController@listarSaidaPorAno')->name('listar_saida_ano');
  //======================= FIM Saida ============================

  //======================= Concurso (resource acima) ============================
  // Relatorios Gerais dos Concursos
  Route::get('/concurso/report_geral_concursos', ['as'=>'rg_concursos', 'uses'=>'ConcursoController@reportGeralConcursos']);
  Route::post('/concurso/report_geral/listar_concurso_mes', 'ConcursoController@listarConcursoPorMes')->name('listar_concurso_mes');
  Route::post('/concurso/report_geral/listar_concurso_ano', 'ConcursoController@listarConcursoPorAno')->name('listar_concurso_ano');
  //======================= FIM Concurso ============================

  //======================= Cotacao (resource acima) ============================
  // Relatorios Gerais dos Concursos
  Route::get('/cotacoes/report_geral_cotacoes', ['as'=>'rg_cotacoes', 'uses'=>'CotacaoController@reportGeralCotacoes']);
  // CADSTRAR TIPO DE COTACAO FAZENDO o redirect()->back() => Malache
  Route::post('/tipo_cotacao/tipo_cotacao_salvar_rback', 'TipoCotacaoController@storeRedirectBack')->name('tipo_cotacao_salvar_rback');
  // EDITAR O MODTIVO JUSTIFICATIVO DA NAO APLICACAO DO IMPOSTO
  Route::post('/cotacao/editar_motivo_justificativo_imposto', 'CotacaoController@motivoNaoAplicacaoImposto')->name('editar_motivo_cotacao');

  //======================= FIM Cotacao ============================

  //======================= INICIO DOS DUPLICADO ============================

  //======================= Entrada DUPICADO pCausa do resource acima ============================
  // Relatorios Gerais da Vendas
  Route::get('/venda/report_geral_vendas', ['as'=>'rg_vendas', 'uses'=>'VendaController@reportGeralVendas']);
  Route::post('/venda/report_geral/listar_vend_mes', 'VendaController@listarVendaPorMes')->name('listar_vend_mes');
  Route::post('/venda/report_geral/listar_vend_ano', 'VendaController@listarVendaPorAno')->name('listar_vend_ano');
  // Impressao Venda
  Route::get('/venda/{id}/relatorio', ['as'=>'vendaRelatorio','uses'=>'VendaController@showRelatorio']);
  //======================= FIM Entrada DUPLICADO ============================

  //======================= Concurso DUPICADO pCausa do resource acima ============================
  // Relatorios Gerais dos Concursos
  Route::get('/concurso/report_geral_concursos', ['as'=>'rg_concursos', 'uses'=>'ConcursoController@reportGeralConcursos']);
  Route::post('/concurso/report_geral/listar_concurso_mes', 'ConcursoController@listarConcursoPorMes')->name('listar_concurso_mes');
  Route::post('/concurso/report_geral/listar_concurso_ano', 'ConcursoController@listarConcursoPorAno')->name('listar_concurso_ano');
  //======================= FIM Concurso DUPLICADO ============================

  //======================= Entrada DUPICADO pCausa do resource acima ============================
  //Relatorios Gerais das Entradas
  Route::get('/entrada/report_geral_entradas', ['as'=>'rg_entradas', 'uses'=>'EntradaController@reportGeralEntradas']);
  Route::post('/entrada/report_geral/listar_entrada_mes', 'EntradaController@listarEntradaPorMes')->name('listar_entrada_mes');
  Route::post('/entrada/report_geral/listar_entrada_ano', 'EntradaController@listarEntradaPorAno')->name('listar_entrada_ano');
  //======================= FIM Entrada DUPLICADO ============================

  //======================= FIM DOS DUPLICADO ============================


  //Rotas de operações
  Route::resource('/fornecedores', 'fornecedorController');
  Route::resource('/produtos', 'produtoController');
  Route::get('/produ', 'produtoController@index');
  Route::get('/produ/dados', 'produtoController@get_datatable');
  Route::resource('/categoria', 'CategoriaController');
  Route::resource('/cliente', 'ClienteController');
  Route::resource('/tipo_cliente', 'TipoClienteController');
  Route::resource('/motivo_nao_aplicacao_iva', 'MotivoNaoAplicacaoIvaController');
  Route::resource('/usuarios', 'UsuarioController');


  Route::resource('/tipo_cotacao', 'TipoCotacaoController');


});
