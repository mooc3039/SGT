<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistema de Gestão de Stocks">
  <meta name="author" content="M2OC -Dev. Ltd.">
  <meta name="keyword" content="Gestão, Stock, Faturação, Produtos, Encomendas">
  <!--{!!Html::image('img/favicon.png')!!}-->
  <title>SG-Stock Login</title>

  {!!Html::style('css/bootstrap.min.css')!!}
  {!!Html::style('css/bootstrap-theme.css')!!}
  {!!Html::style('css/elegant-icons-style.css')!!}
  {!!Html::style('css/font-awesome.css')!!}
  {!!Html::style('css/style.css')!!}
  {!!Html::style('css/style-responsive.css')!!}
</head>

<body class="">

  <div class="container">

    <form class="login-form" action="{{ route('login')}}" method="post">
      {!! csrf_field() !!}
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
          <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
        </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit" style="margin-bottom: 15px">Login</button>
        <!-- <button class="btn btn-info btn-lg btn-block" type="submit">Signup</button> -->
        

        @if($errors->first('username'))
        <div class="alert alert-danger" style="text-align: center;">
          <span>
            Usuário ou senha incorrectos.
          </span>
          @endif


          @if($errors->first('password'))
          <div class="alert alert-danger" style="text-align: center;">
            <span>
              Usuário ou senha incorrectos.
            </span>
            @endif

          </div>
        </div>
      </form>
      <div class="text-center">
        <div class="credits">

          <a href="#/">Sistema de Gestão de Stock</a> desenvolvido por <a href="#/">MOOC -Dev. Ltd.</a>
        </div>
      </div>
    </div>


  </body>

  </html>
