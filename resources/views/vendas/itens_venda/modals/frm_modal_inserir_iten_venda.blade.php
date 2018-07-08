<div class="modal fade" tabindex="-1" role="dialog" id="modalInserirItem">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>Venda: </b>Novo Item<span id=""><span/></h4>
				</div>
				<div class="modal-body">

					{{Form::open(['route'=>'iten_venda.store', 'method'=>'POST', 'onsubmit'=>'submitFormVenda.disabled = true; return true;'])}}

					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('descricao', 'Designação', ['class'=>'control-lable'])}}
								{{ Form::select('produto_id', [''=>'Produto',] + $produtos, null, ['class'=>'form-control', 'id'=>'new_produto_id']) }}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('quantidade', 'Quantidade', ['class'=>'control-lable'])}}
								{{Form::text('quantidade', null, ['placeholder' => 'Quantidade', 'class' => 'form-control', 'id'=>'new_quantidade'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('quantidade_dispo', 'Quantidade-Disponível', ['class'=>'control-lable'])}}

								{{Form::text('quantidade_dispo', null, ['class' => 'form-control', 'id'=>'new_quantidade_dispo', 'readonly'])}}

								{{Form::hidden('new_qtd_dispo_referencial', null, ['class' => 'form-control', 'id'=>'new_qtd_dispo_referencial', 'readonly'])}}

								{{ Form::hidden('venda_id', null, ['id'=>'new_venda_id']) }}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('preco_venda', 'Preço Unitário (Mtn)', ['class'=>'control-lable'])}}
								{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'new_preco_venda', 'disabled'])}}
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('valor', 'Valor (Mtn)', ['class'=>'control-lable'])}}
								{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'new_valor', 'readonly'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('desconto', 'Desconto (%)', ['class'=>'control-lable'])}}
								{{Form::text('desconto', 0, ['placeholder' => 'Desconto', 'class' => 'form-control', 'id'=>'new_desconto'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('subtotal', 'Subtotal (Mtn)', ['class'=>'control-lable'])}}
								{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'new_subtotal', 'readonly'])}}
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6 text-left">
							<table>
								<tr>
									<td><h5>Montante Geral da Cotação </h5></td>
									<td></td>
									<td> <h5><b>: <span class="new_valor_total_sem_iva"></span></b></h5></td>
								</tr>
								<tr>
									<td class="hide_iva"><h5>IVA(17%) </h5> </td>
									<td></td>
									<td class="hide_iva"><h5><b>: <span class="new_iva"></span></b></h5> </td>
								</tr>
								<tr>
									<td class="hide_iva"><h5> Montante Geral da Cotação </h5></td>
									<td></td>
									<td class="hide_iva"><h5><b>: <span class="new_valor_total_iva"></span></b></h5></td>
								</tr>
							</table>
						</div>
						<div class="col-md-6 text-right">
							{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
							{{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormVenda', 'id'=>'submitFormVenda'])}}
						</div>
					</div>



					{{Form::close()}}
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->