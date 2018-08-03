@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Configurações</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Configurações</a></li>
      <li><i class="icon_document_alt"></i>Tipo de Usúario</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Tipo de Usúario</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
     <!--  <header class="panel-heading">
        Parametrizar Produtos
      </header> -->

      @if(isset($role))

      {{Form::model($role, ['route'=>['role.update', $role->id], 'method'=>'PUT'])}}

      @else

      {!! Form::open(['route'=>'role.store', 'method'=>'POST']) !!}

      @endif

      <!-- <div class="panel-footer"></div> -->


      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

        <div class="row" style="margin-bottom: 15px;">

          <div class="form-horizontal">

            <div class="col-sm-4">
              {{Form::label('nome', 'Tipo de Usúario')}}
              {{Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Tipo de Usúario'])}}
            </div>

          </div>

        </div>

        <div class="row">
          <div class="form-horizontal">
            <div class="col-md-12">
              @foreach($permissoes as $permissao)
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="check_permissoes[]" value="{{$permissao->id}}"
                  @if(isset($role))
                  @if($role->permissoes->contains($permissao->id))
                  {{'checked'}}
                  @endif
                  @endif
                  >
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

            @if(isset($role))

            {{Form::hidden('role_id', $role->id)}} <!-- Para ser capturado no FormReques para ignorar a validacao uniq para o campo nome durante o update -->

            {{ Form::button('Actualizar', ['type'=>'submit', 'class'=>'btn btn-primary submit_iten']) }}

            @else

            {{ Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-primary submit_iten']) }}
            {{ Form::reset('Limpar', ['class'=>'btn btn-default']) }}

            @endif

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