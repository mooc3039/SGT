<div class="modal fade" tabindex="-1" role="dialog" id="modalInserirItem">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>Concurso: </b>Novo Item<span id=""><span/></h4>
				</div>
				<div class="modal-body">

					{{Form::open(['route'=>'iten_concurso.store', 'method'=>'POST', 'onsubmit'=>'submitFormEntrada.disabled = true; return true;'])}}

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
								<!-- {{Form::label('quantidade_dispo', 'Quantidade-Disponível', ['class'=>'control-lable'])}}

								{{Form::text('quantidade_dispo', null, ['class' => 'form-control', 'id'=>'new_quantidade_dispo', 'readonly'])}}

								{{Form::hidden('new_qtd_dispo_referencial', null, ['class' => 'form-control', 'id'=>'new_qtd_dispo_referencial', 'readonly'])}} -->

								<div class="form-group">
									{{Form::label('preco_venda', 'Preço Unitário Venda', ['class'=>'control-lable'])}}
									{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'new_preco_venda', 'readonly'])}}
								</div>

								{{ Form::hidden('concurso_id', null, ['id'=>'new_concurso_id']) }}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('valor', 'Valor', ['class'=>'control-lable'])}}
								{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'new_valor', 'readonly'])}}
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('subtotal', 'Subtotal', ['class'=>'control-lable'])}}
								{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'new_subtotal', 'readonly'])}}
							</div>
							{{Form::hidden('desconto', 0, ['placeholder' => 'Desconto', 'class' => 'form-control', 'id'=>'new_desconto'])}}

							{{Form::hidden('codigo_concurso', 0, ['class' => 'form-control', 'id'=>'new_codigo_concurso'])}}

							{{ Form::hidden('user_id', Auth::user()->id) }}
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6 text-left">
							<h5>Montante Geral do Concurso: <b><span id="new_val_temp"></span></b></h5>
						</div>
						<div class="col-md-6 text-right">
							{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
							{{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormEntrada', 'id'=>'submitFormEntrada'])}}
						</div>
					</div>



					{{Form::close()}}
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->