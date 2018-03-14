
@extends('layouts.master')
@section('content')

        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user-md"></i> Perfíl</h3>
            
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{ route('paginainicial' )}}">Home</a></li>
              <li><i class="fa fa-user-md"></i>Perfíl</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <!-- profile-widget -->
          <div class="col-lg-12">
            <div class="profile-widget profile-widget-info">
              <div class="panel-body">
                <div class="col-lg-2 col-sm-2">
                  <h4>{{ $user->name }}</h4>
                  <div class="follow-ava">
                    <img src="/img/profile/{{$user->avatar}}" alt="">
                  </div>
                  <h6>Administrator</h6>
                </div>
                <div class="col-lg-4 col-sm-4 follow-info">
                  <p>{{ $user->about }}</p>
                  <p>{{$user->username}}</p>
                  <p><i class="fa fa-twitter"></i></p>
                  <h6>
                                    <span><i class="icon_clock_alt"></i> {{date('h:i:s A')}}</span>
                                    <span><i class="icon_calendar"></i> {{date('l jS F Y')}}</span>
                                    <span><i class="icon_pin_alt"></i>Mz</span>
                                </h6>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading tab-bg-info">
                <ul class="nav nav-tabs">

                  <li class="active">
                    <a data-toggle="tab" href="#profile">
                                      <i class="icon-user"></i>
                                          Perfíl
                                      </a>
                  </li>
                  <li class="">
                    <a data-toggle="tab" href="#edit-profile">
                                          <i class="icon-envelope"></i>
                                          Editar Perfíl
                                      </a>
                  </li>
                  <li class="">
                    <a data-toggle="tab" href="#image-edit-profile">
                                          <i class="icon-envelope"></i>
                                          Editar Imagem de Perfíl
                                      </a>
                  </li>
                </ul>
              </header>
              <div class="panel-body">
                <div class="tab-content">

                  <!-- profile -->
                  <div id="profile" class="tab-pane active">
                    <section class="panel">
                      <div class="bio-graph-heading">
                        {{ $user->about }}
                      </div>
                      <div class="panel-body bio-graph-info">
                        <h1>Dados Pessoais</h1>
                        <div class="row">
                          <div class="bio-row">
                            <p><span>Nome </span>: {{ $user->name }}</p>
                          </div>
                          <div class="bio-row">
                            <p><span>Data Nasc.</span>: {{ $user->bday }}</p>
                          </div>
                          <div class="bio-row">
                            <p><span>Endereço </span>: {{ $user->endereco }}</p>
                          </div>
                          <div class="bio-row">
                            <p><span>Ocupação </span>: {{ $user->occupation }}</p>
                          </div>
                          <div class="bio-row">
                            <p><span>Email </span>:{{ $user->email }}</p>
                          </div>
                          <div class="bio-row">
                            <p><span>Telefone </span>: {{$user->telefone }}</p>
                          </div>

                        </div>
                      </div>
                    </section>
                    <section>
                      <div class="row">
                      </div>
                    </section>
                  </div>


                  <!-- image edit-profile -->
                  <div id="image-edit-profile" class="tab-pane">
                    <section class="panel">
                      <div class="panel-body bio-graph-info">
                        <h1> Editar imagem do Perfíl</h1>
                        <form class="form-horizontal" role="form" enctype="multipart/form-data" action="/dashboard/{name}/profile_img" method="POST">

                          <div class="form-group">
                            <label class="col-lg-2 control-label">Actualizar Imagem</label>
                            <div class="col-lg-6">
                              <input type="file" class="form-control" name="avatar">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                            <div class="col-sm-4">
                              <span class="profile-ava">
                                  <img alt="" src="/img/profile/{{Auth::user()->avatar}}" style="width:64px; height:64px;">
                              </span>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-primary">Actualizar</button>
                              <button type="button" class="btn btn-danger">Cancelar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </section>
                  </div>

                  <!-- edit-profile -->
                  <div id="edit-profile" class="tab-pane">
                    <section class="panel">
                      <div class="panel-body bio-graph-info">
                        <h1> Informação do Usuário</h1>
                        <form class="form-horizontal" role="form" action="/dashboard/{{Auth::user()->name}}/profile_edit" method="POST">
                          {{ csrf_field() }}
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Nome Completo</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" name="name" value="{{$user->name}}">
                            </div>
                            @if($errors->has('name'))
                              <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                              </span>
                            @endif
                          </div>

                          <div class="form-group">
                            <label class="col-lg-2 control-label">Sobre Mim</label>
                            <div class="col-lg-10">
                              <textarea name="about" id="" class="form-control" cols="30" rows="5">{{$user->about}}</textarea>
                            </div>
                            @if($errors->has('about'))
                              <span class="help-block">
                                <strong>{{ $errors->first('about') }}</strong>
                              </span>
                            @endif
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Endereço</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" name="endereco" value="{{$user->endereco}}">
                            </div>
                            @if($errors->has('endereco'))
                              <span class="help-block">
                                <strong>{{ $errors->first('endereco') }}</strong>
                              </span>
                            @endif
                          </div>

                          <div class="form-group">
                            <label class="col-lg-2 control-label">Data Nasc.</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" name="bday" value="{{$user->bday}}">
                            </div>
                            @if($errors->has('bday'))
                              <span class="help-block">
                                <strong>{{ $errors->first('bday') }}</strong>
                              </span>
                            @endif
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Ocupação</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" name="occupation" value="{{$user->occupation}}">
                            </div>
                            @if($errors->has('occupation'))
                              <span class="help-block">
                                <strong>{{ $errors->first('occupation') }}</strong>
                              </span>
                            @endif
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-6">
                              <input type="email" class="form-control" name="email" value="{{$user->email}}">
                            </div>
                            @if($errors->has('email'))
                              <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                              </span>
                            @endif
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Telefone</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" name="telefone" value="{{$user->telefone}}">
                            </div>
                            @if($errors->has('telefone'))
                              <span class="help-block">
                                <strong>{{ $errors->first('telefone') }}</strong>
                              </span>
                            @endif
                          </div>

                          <div class="form-group">
                            <label class="col-lg-2 control-label">Password Reset</label>
                            <div class="col-lg-3">
                              <input type="password" class="form-control" name="password" placeholder="Senha">
                            </div>
                            <div class="col-lg-3">
                              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar senha">
                            </div>
                            @if($errors->has('password'))
                              <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                              </span>
                            @endif
                            @if($errors->has('password_confirmation'))
                              <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                              </span>
                            @endif
                          </div>

                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-primary">Actualizar</button>
                              <button type="button" class="btn btn-danger">Cancelar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>



    <script>
    //knob
        $(".knob").knob();
    </script>
    @endsection
