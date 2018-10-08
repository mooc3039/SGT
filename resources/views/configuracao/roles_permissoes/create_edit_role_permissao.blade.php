@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Configurações</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Configurações</a></li>
      <li><i class="icon_document_alt"></i>Tipo de Usúario & Permissões</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Tipo de Usúario & Permissões</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">

      {!! Form::open(['route'=>'role_permissao.store', 'method'=>'POST']) !!}

      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

        <div class="row" style="margin-bottom: 15px;">

          <div class="form-horizontal">

            <div class="col-sm-4">
              {{Form::label('role_id', 'Tipo de Usúario')}}
              {!! Form::select('role_id', ['' => 'Selecione o Tipo de Usuário',] + $roles, null, ['class'=>'form-control']) !!}
            </div>

          </div>

        </div>
        <div class="row">
        	<div class="form-horizontal">
        		<div class="col-md-12">
        			@foreach($permissoes as $permissao)
        			<div class="checkbox">
        				<label>
        					<input type="checkbox" name="check_permissoes[]" value="{{$permissao->id}}">
        					{{$permissao->nome}}
        				</label>
        			</div>
        			@endforeach
        		</div>
        	</div>
        </div>

      </div>

      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6">

            {!! Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-primary submit_iten']) !!}

            {!! Form::reset('Limpar', ['class' => 'btn btn-default']) !!}

          </div>
          <div class="col-md-6 text-right">

            <a href="{{route('role.index')}}" class="btn btn-warning"> Cancelar </a>
          </div>
        </div>

      </div>

      {!! Form::close() !!}

    </section>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

  $('.submit_iten').on('click',function(){
    $(".wait").css("display", "block");
  });

</script>
@endsection