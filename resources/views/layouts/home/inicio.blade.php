@extends('layouts.master')
@section('content')
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
              <i class="fa fa-user"></i>
              <div class="count">{{$total_cliente}}</div>
              <div class="title">Clientes</div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box brown-bg">
              <i class="fa fa-shopping-cart"></i>
              <div class="count">{{ $total_facturacao}}</div>
              <div class="title">Facturações</div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <i class="fa fa-thumbs-o-up"></i>
              <div class="count">{{$total_fornecedor}}</div>
              <div class="title">Fornecedores</div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
              <i class="fa fa-cubes"></i>
              <div class="count">{{$total_stock}}</div>
              <div class="title">Stock</div>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->
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


        