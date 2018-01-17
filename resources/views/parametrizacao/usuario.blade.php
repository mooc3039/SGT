@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Usuários</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Usuários</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Parametrizar Usuários do Sistema
      </header>
      <form class="form-horizontal" id="frm-create-class">
        {{csrf_field()}}
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

            <div class="col-sm-3">
                  <label for="role_id">Função/Papel</label>
                  <div class="input-group">
                    <select class="form-control" name="role_id" id="role_id">
                    </select>
                    <div class="input-group-addon">
                      <span class="fa fa-plus"></span>
                    </div>
                  </div>
                </div>

            <div class="col-sm-3">
              <label for="nome">Nome Completo</label>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="Nome Completo">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user" ></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="usuario">Usuário</label>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="Usuário">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user" ></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="">email</label>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="Email">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user" ></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="senha">Senha</label>
              <div class="input-group">
                <input type="password" name="" id="senha" class="form-control">
                <div class="input-group-addon">
                  <span class=""></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="estado">Estado/Status</label>
              <div class="input-group">
                <select class="form-control" name="estado" id="estado">
                </select>
                <div class="input-group-addon">
                  <span class=""></span>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="panel-footer">
          <button type="submit" class="btn btn-default btn-sm">Adicionar Usuário</button>
        </div>
      </form>
    </section>
  </div>
</div>

@endsection
