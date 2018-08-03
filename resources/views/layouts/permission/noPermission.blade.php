@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>ACL - Relatório</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Nivél de Acesso</li>
    </ol>
  </div>
</div>
<div class="">
    <h1>Olá <strong>{{ Auth::user()->name }}</strong>, não está autorizado à aceder essa parte do sistema!</h1>

    <h2>Erro respectivo ao nivél de acesso</h2>
    <p> Contacte o administrador do Sistema! <br><a href="{{route('dashboard')}}">Página Inicial</a></p>
  </div>

@endsection
