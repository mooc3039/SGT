<div class="modal fade" tabindex="-1" role="dialog" id="modalProdutoIten">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>Guia de Entrega: </b>Editar Item<span id=""><span/></h4>
				</div>
				<div class="modal-body">

					{{Form::open(['route'=>['iten_guia_entrega.update', 'id'], 'method'=>'PUT', 'onsubmit'=>'submitFormGuiaEntrega.disabled = true; return true;'])}}

					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('descricao', 'Designação', ['class'=>'control-lable'])}}
								{{Form::text('descricao', null, ['placeholder' => 'Nome', 'class' => 'form-control', 'id'=>'descricao', 'disabled'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('quantidade', 'Quantidade', ['class'=>'control-lable'])}}
								{{Form::text('quantidade', null, ['placeholder' => 'Quantidade', 'class' => 'form-control', 'id'=>'quantidade'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">

								{{Form::label('quantidade', 'Quantidade-Disponível', ['class'=>'control-lable'])}}
								{{Form::text('qtd_rest_iten_saida', null, ['class' => 'form-control', 'id'=>'qtd_rest_iten_saida', 'disabled'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('preco_venda', 'Preço Unitário', ['class'=>'control-lable'])}}
								{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'preco_venda', 'disabled'])}}
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('valor', 'Valor', ['class'=>'control-lable'])}}
								{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'valor', 'readonly'])}}

							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('desconto', 'Desconto', ['class'=>'control-lable'])}}
								{{Form::text('desconto', null, ['placeholder' => 'Desconto', 'class' => 'form-control', 'id'=>'desconto', 'readonly'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('subtotal', 'Subtotal', ['class'=>'control-lable'])}}
								{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'subtotal', 'readonly'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{ Form::hidden('valor_total', null, ['id'=>'valor_total']) }}
								{{ Form::hidden('guia_entrega_id', null, ['id'=>'guia_entrega_id']) }}
								{{ Form::hidden('produto_id', null, ['id'=>'produto_id']) }}
								{{ Form::hidden('qtd_referencial', null, ['id'=>'qtd_referencial']) }}
								{{ Form::hidden('user_id', null, ['id'=>'user_id']) }}
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6 text-left">
							<h5>Montante Geral da Guia: <b><span id="val_temp"></span></b></h5>
						</div>
						<div class="col-md-6 text-right">
							{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
							{{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormGuiaEntrega', 'id'=>'submitFormGuiaEntrega'])}}
						</div>
					</div>



					{{Form::close()}}
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->