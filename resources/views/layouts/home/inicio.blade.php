@extends('layouts.master')
@section('content')
<div class="row" style="margin-bottom: 150px">
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

    <div class="info-box blue-bg">
      <i class="fa fa-sign-in"></i>
      <div class="count">{{$valor_entrada}}</div>
      <div class="title">Valor Entradas / Mês</div>
      <div class="count">{{$valor_entrada_pago}}</div>
      <div class="title">Valor Pago</div>
    </div>
    <!--/.info-box-->
  </div>

   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box brown-bg">
      <i class="fa fa-share-square-o"></i>
      <div class="count">{{$valor_saida}}</div>
      <div class="title">Valor Facturacoes / Mês</div>
      <div class="count">{{$valor_saida_pago}}</div>
      <div class="title">Valor Pago</div>
    </div>
  </div> 

  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box green-bg">
      <i class="fa fa-shopping-cart"></i>
      <div class="count">{{$valor_venda}}</div>
      <div class="title">Valor Vendas / Mês</div>
      <div class="count">{{$valor_venda_pago}}</div>
      <div class="title">Valor Pago</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box orange-bg">
      <i class="fa fa-cubes"></i>
      <div class="count">{{$total_fornecedor}}</div>
      <div class="title">Fornecedores</div>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box dark-bg">
      <i class="fa fa-users"></i>
      <div class="count">{{$total_cliente_publico}}</div>
      <div class="title">Instituicoes Publicas</div>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box red-bg">
      <i class="fa fa-users"></i>
      <div class="count">{{$total_cliente_privado}}</div>
      <div class="title">Clientes Privados</div>
    </div>
  </div>
</div>
<!--parei um bocado a biblioteca de graficos porque carrega scripts directamente da net, é só ver no chart.php na pasta config-->
<!--
        <div class="row">
          
          <div class="col-lg-12">
              <section class="panel">
                  <header class="panel-heading">
                      facturaçoes
                  </header>
                  <div class="panel-body text-center">
                    
                  </div>
              </section>
          </div>   

      </div> 
    -->
    @endsection


