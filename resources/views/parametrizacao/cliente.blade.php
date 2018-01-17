@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Clientes</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Clientes</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Parametrizar Cliente
      </header>
      <form class="form-horizontal" id="frm-create-class">
        {{csrf_field()}}
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

            <div class="col-sm-3">
                  <label for="cliente_id">Nome do Cliente</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="" placeholder="Nome do Cliente">
                    <div class="input-group-addon">
                      <span class="fa fa-plus"></span>
                    </div>
                  </div>
                </div>

            <div class="col-sm-3">
              <label for="categoria">Categoria/Tipo</label>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="Categoria">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user" ></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="contacto">Contacto</label>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="Contacto">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user" ></span>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <label for="email">Email</label>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="email">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user" ></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="">Concurso</label>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="concurso">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user" ></span>
                </div>
              </div>
            </div>


          </div>
        </div>

        <div class="panel-footer">
          <button type="submit" class="btn btn-default btn-sm">Adicionar Cliente</button>
        </div>
      </form>
    </section>
  </div>
</div>

@endsection
