@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-8">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Guias de Entrega</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Guias de Entrega</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div id="wait" style=" 
    text-align: center; 
    z-index: 1; 
    display:none;
    width:100%;
    height:100%;
    position:absolute;
    top:0;
    left:0;
    padding:5px;">

    <div id="wait-loader" style="
    position:absolute;    
    left:40%;
    top:40%;
    font-size: 50px; 
    color: blue;">
    <!-- <i class="fa fa-plus text-center"> -->
      <img src="{{asset('/img/Gear-0.6s-200px.gif')}}"/>
    </i>
    <!-- <h2>Aguarde...</h2> -->
  </div>

</div>
<section class="panel panel-default">
      <!-- <header class="panel-heading">
        Guias de Entrega
      </header> -->
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover">
              <thead>
                <tr>
                  <th><i class="icon_profile"></i>Código da Guia </th>
                  <th><i class="icon_profile"></i>Código da Saída </th>
                  <th><i class="icon_mobile"></i> Data de Emissão </th>
                  <th><i class="icon_mail_alt"></i> Cliente </th>
                  <th><i class="icon_mail_alt"></i> Valor Total </th>
                  <th class="text-right"><i class="icon_cogs"></i> Operações </th>
                </tr>
              </thead>
              <tbody>
                @foreach($guias_entrega as $guia_entrega)
                <tr>
                  <td> {{$guia_entrega->id}} </td>
                  <td> {{$guia_entrega->saida_id}} </td>
                  <td> {{$guia_entrega->created_at}} </td>
                  <td> {{$guia_entrega->cliente->nome}} </td>
                  <td> {{$guia_entrega->valor_total}} </td>
                  <td class="text-right">
                    {{ Form::open(['route'=>['guia_entrega.destroy', $guia_entrega->id], 'method'=>'DELETE'])}}
                    {{ Form::button('Cancelar Guia', ['type'=>'submit', 'class'=>'btn btn-danger btn-sm submit_iten'])}}
                    <div class="btn-group btn-group-sm">
                      <a class="btn btn-success" href="{{route('guia_entrega.edit', $guia_entrega->id)}}"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-primary" href="{{route('guia_entrega.show', $guia_entrega->id)}}"><i class="fa fa-eye"></i></a>

                    </div>
                    {{Form::close()}}
                  </td>

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6">
            {{ $guias_entrega->links() }}
          </div>
          <div class="col-md-6 text-right">
            <a href="{{ route('saida.index') }}" class="btn btn-warning"><i class="fa fa-list"></i> Lista Facturas </a>
          </div>
        </div>
      </div>

    </section>
  </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('.submit_iten').on('click',function(){
      $("#wait").css("display", "block");
    });
  });
</script>
@endsection
