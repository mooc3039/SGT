@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Facturação</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Facturação</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Facturas</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Gerenciamento das Facturas
      </header>
      <form class="form-horizontal" id="frm-create-class">
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

            <div class="col-sm-3">
              <label for="academic-year">Quantidade(Kg)</label>
              <div class="input-group">
                <select class="form-control" name="academic_id" id="academic_id">

                </select>
                <div class="input-group-addon">
                  <span class="fa fa-plus" id="add-more-academic"></span>
                </div>
              </div>
            </div>

            <div class="col-sm-4">
              <label for="program">Produto</label>
              <div class="input-group">
                <select class="form-control" name="program_id" id="program_id">

                </select>
                <div class="input-group-addon">
                  <span class="fa fa-plus" id="add-more-program"></span>
                </div>
              </div>
            </div>

            <div class="col-sm-5">
              <label for="level">Fornecedor</label>
              <div class="input-group">
                <select class="form-control" name="level_id" id="level_id">

                </select>
                <div class="input-group-addon">
                  <span class="fa fa-plus" id="add-more-level"></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="shift">Fabricante</label>
              <div class="input-group">
                <select class="form-control" name="shift_id" id="shift_id">

                </select>
                <div class="input-group-addon">
                  <span class="fa fa-plus"></span>
                </div>
              </div>
            </div>

            <div class="col-sm-4">
              <label for="batch">Total Pago</label>
              <div class="input-group">
                <select class="form-control" name="batch_id" id="batch_id">

                </select>
                <div class="input-group-addon">
                  <span class="fa fa-plus"></span>
                </div>
              </div>
            </div>

            <div class="col-sm-5">
              <label for="group">Linhagem</label>
              <div class="input-group">
                <select class="form-control" name="group_id" id="group_id">

                </select>
                <div class="input-group-addon">
                  <span class="fa fa-plus"></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="startDate">Data de Entrada</label>
              <div class="input-group">
                <input type="text" name="start_date" id="start_date" class="form-control">
                <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <label for="endDate">Validade</label>
              <div class="input-group">
                <input type="text" name="end_date" id="end_date" class="form-control">
                <div class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="panel-footer">
          <button type="submit" class="btn btn-default btn-sm">Adicionar Produto</button>
        </div>
      </form>
    </section>
  </div>
</div>
@endsection
