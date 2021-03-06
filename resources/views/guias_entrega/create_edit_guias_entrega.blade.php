@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-8">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Guias de Entrega</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Guia de Entrega</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Guia de Entrega</li>
    </ol>
  </div>
  <div class="col-lg-4 text-right">
    <h3>Factura: <b>{{ $saida->codigo }}</b></h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="col-md-12">
      <section class="panel panel-default">

        {{ Form::model($saida,['route'=>'guia_entrega.store', 'method'=>'POST']) }}

        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="row" style="margin-bottom: 15px">
            <div class="form-horizontal">

              <div class="col-sm-4">
                {{ Form::label('cliente_id', 'Cliente')}}
                {{ Form::text('cliente', $saida->cliente->nome, ['class'=>'form-control', 'disabled'])}}
                {{ Form::hidden('cliente_id', $saida->cliente->id, ['class'=>'form-control'])}}
              </div>

            </div>
          </div>
        </div>

        <div class="panel-footer">
          {{Form::submit('Salvar Guia de Entrega', ['class'=>'btn btn-primary submit_guia_entrega'])}}
        </div>


        <!-- começa a secção de cotacao na tabela-->

        <section class="panel">
          <header class="panel-heading">
            Produtos / Itens
          </header>

          <div class="panel-body">
            <table class="table table-striped table-advance table-hover">
              <thead>
                <tr>
                  <th> Nome do Produto</th>
                  <th> Qtd</th>
                  <th> Qtd/Saida</th>
                  <th> Preço</th>
                  <th> Valor</th>
                  <th> Desconto</th>
                  <th><i class="icon_mobile"></i> Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($saida->itensSaida as $iten_saida)
                <tr>
                  <td>
                    {{ Form::text('descricao[]', $iten_saida->produto->descricao, ['class'=>'form-control', 'id'=>'descricao', 'disabled', 'style'=>'width:auto'])}}
                    {{ Form::hidden('produto_id[]', $iten_saida->produto->id, ['id'=>'produto_id'])}}
                  </td>
                  <td>
                    {{ Form::text('quantidade[]', null, ['class'=>'form-control', 'id'=>'quantidade'])}}
                  </td>
                  <td>
                    {{ Form::text('quantidade_rest_iten_saida[]', $iten_saida->quantidade_rest, ['class'=>'form-control', 'id'=>'quantidade_rest_iten_saida', 'readonly'])}}

                    {{ Form::hidden('qtd_original_saida[]', $iten_saida->quantidade_rest, ['class'=>'form-control', 'id'=>'qtd_original_saida', 'disabled'])}}


                  </td>
                  <td>{{ Form::text('preco_venda[]', number_format($iten_saida->produto->preco_venda, 2, '.', ','), ['class'=>'form-control', 'id'=>'preco_venda', 'disabled'])}}</td>
                  <td>{{ Form::text('valor[]', null, ['class'=>'form-control', 'id'=>'valor', 'readonly'])}}</td>
                  <td>{{ Form::text('desconto[]', $iten_saida->desconto, ['class'=>'form-control', 'id'=>'desconto', 'readonly'])}}</td>
                  <td>
                    {{ Form::text('subtotal[]', null, ['class'=>'form-control', 'id'=>'subtotal', 'readonly'])}}

                    {{ Form::hidden('iten_saida_id[]', $iten_saida->id, ['class'=>'form-control', 'id'=>'iten_saida_id'])}}
                  </td>
                </tr>
                @endforeach

              </tbody>
             <!--  <tfoot>
                <tr>
                  <td style="border:none"></td>
                  <td style="border:none"></td>
                  <td style="border:none"></td>
                  <td style="border:none"></td>
                  <td><b>Total</b></td>
                  <td><b><div class="valor_total_visual" style="border:none"> </div></b></td>
                  <td></td>
                </tr>
              </tfoot> -->
            </table>
          </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col-md-6"></div>
              <div class="col-md-6 text-right">
                <a href="{{ route('saida.index')}}" class="btn btn-warning">Cancelar</a>
              </div>
            </div>
          </div>
        </section>
        {{ Form::hidden('saida_id', $saida->id, ['class'=>'valor_total']) }}
        {{ Form::hidden('valor_total', 0, ['class'=>'valor_total']) }}
        {{ Form::hidden('user_id', Auth::user()->id) }}
        {!!Form::hidden('_token',csrf_token())!!}
        {{ Form::close() }}
      </section>
    </div>
  </div>
  @endsection

  @section('script')
  <script type="text/javascript">

    $(document).ready(function(){
      $('.submit_guia_entrega').on('click',function(){
        $(".wait").css("display", "block");
      });
    });


    $('tbody').delegate('#quantidade,#preco_venda,#desconto','keyup',function(){
      var tr = $(this).parent().parent();

      numberOnly(tr.find('#quantidade')); // Campo aceita apenas numeros

      var quantidade = Number.parseInt(0);
      if( (tr.find('#quantidade').val()) === "" || (tr.find('#quantidade').val()) === null){
        quantidade = Number.parseInt(0);
      }else{
        quantidade = Number.parseInt(tr.find('#quantidade').val());
      }

      var preco_venda = Number.parseFloat((tr.find('#preco_venda').val()).replace(/[^0-9-.]/g, ''));
      var valor = Number.parseFloat((quantidade*preco_venda));
      var desconto = tr.find('#desconto').val();
      var subtotal = Number.parseFloat((quantidade*preco_venda)-(quantidade*preco_venda*desconto)/100);
      tr.find('#subtotal').val(subtotal.formatMoney());
      tr.find('#valor').val(valor.formatMoney());

      var qtd_org_sai = Number.parseInt(tr.find('#qtd_original_saida').val());
      // Se a quantidade especificada for maior que a quantidade disponivel, mostra um alerta impedindo de avancar e reseta a quantidade escolhida para a quantidade disponivel no iten_saida. Neste processo actualiza o valor e o subtotal de acordoo com a quantidade, tanto ao exceder o limite como nao
      if(quantidade > qtd_org_sai){
        alert('A quantidade especificada excedeu o limite');
        tr.find('#quantidade').val(qtd_org_sai);
        //

        var qtd_after_validation_fail = Number.parseInt(tr.find('#quantidade').val());
        var qtd_rest_after_validation_fail = qtd_org_sai-qtd_after_validation_fail;
        

        var valor_after_validation_fail = Number.parseFloat((qtd_org_sai*preco_venda));
        var subtotal_after_validation_fail = Number.parseFloat( (qtd_org_sai*preco_venda)-(qtd_org_sai*preco_venda*desconto)/100);

        tr.find('#quantidade_rest_iten_saida').val(qtd_rest_after_validation_fail);
        tr.find('#valor').val(valor_after_validation_fail.formatMoney());
        tr.find('#subtotal').val(subtotal_after_validation_fail.formatMoney());

      }else{
        tr.find('#quantidade').val(quantidade);
        var quantidade_rest_iten_saida = (qtd_org_sai-quantidade);
        tr.find('#quantidade_rest_iten_saida').val(quantidade_rest_iten_saida);
      }
      // total();



    });


  </script>
  @endsection