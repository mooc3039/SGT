<div class="modal fade" tabindex="-1" role="dialog" id="modalProdutoIten">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>Concurso: </b>Editar Item<span id=""></span></h4>
			</div>
			<div class="modal-body">

				{{Form::open(['route'=>['iten_concurso.update', 'id'], 'method'=>'PUT', 'onsubmit'=>'submitFormEntrada.disabled = true; return true;'])}}

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
							<!-- {{Form::label('quantidade_dispo', 'Quantidade-Disponível', ['class'=>'control-lable'])}}

							{{Form::text('quantidade_dispo', null, ['class' => 'form-control', 'id'=>'quantidade_dispo'])}} -->

							<div class="form-group">
							{{Form::label('preco_venda', 'Preço Unitário Venda', ['class'=>'control-lable'])}}
							{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'preco_venda', 'readonly'])}}
						</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							{{Form::label('subtotal', 'Subtotal', ['class'=>'control-lable'])}}
							{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'subtotal', 'readonly'])}}
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							
							<!-- {{Form::label('valor', 'Valor', ['class'=>'control-lable'])}} -->
							{{Form::hidden('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'valor', 'readonly'])}}

							{{Form::hidden('desconto', null, ['id'=>'desconto'])}}
							{{ Form::hidden('concurso_id', null, ['id'=>'concurso_id']) }}
							{{Form::hidden('codigo_concurso', 0, ['id'=>'codigo_concurso'])}}
							{{ Form::hidden('produto_id', null, ['id'=>'produto_id']) }}
							{{ Form::hidden('user_id', null, ['id'=>'user_id']) }}

							<!-- este input abaixo eh para efeitos de validacao da qtd no controller -->

							<!-- {{Form::hidden('qtd_dispo_referencial', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'qtd_dispo_referencial', 'readonly'])}} -->
						</div>
					</div>

				</div>

			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-6 text-left">
						<h5>Subtotal Geral do Concurso: <b><span id="val_temp"></span></b></h5>
					</div>
					<div class="col-md-6 text-right">
						{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
						{{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormEntrada', 'id'=>'submitFormEntrada'])}}
					</div>
				</div>



				{{Form::close()}}
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->