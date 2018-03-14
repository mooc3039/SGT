<!--sidebar start-->
<aside>
  <div id="sidebar" class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu">
      <li class="active">
        <a class="" href="{{ route('paginainicial' )}}">
                      <i class="icon_house_alt"></i>
                      <span>Administração </span>
                  </a>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="icon_desktop"></i>
                      <span>Facturação</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="{{route('saida.index')}}"><i class="fa fa-suitcase"></i>Saídas</a></li>
          <li><a class="" href="{{route('cotacao.index')}}"><i class="fa fa-file"></i>Cotações</a></li>
          <li><a class="" href="{{route('entrada.index')}}"><i class="fa fa-sign-out"></i>Entradas</a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="icon_table"></i>
                      <span>Stocks</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="{{ route('indexStock') }}"><i class="fa fa-paperclip"></i>Todos Produtos</a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="icon_documents_alt"></i>
                      <span>Parametrização</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="{{ route('fornecedores.index') }}"><i class="fa fa-tag"></i>Fornecedores</a></li>
          <li><a class="" href="{{ route('produtos.index') }}"><i class="fa fa-tag"></i>Produtos</a></li>
          <li><a class="" href="{{ route('categoria.index') }}"><i class="fa fa-tag"></i>Categorias</a></li>
          <li><a class="" href="{{ route('indexUsuario') }}"><i class="fa fa-tag"></i>Usuários</a></li>
          <li><a class="" href="{{ route('cliente.index') }}"><i class="fa fa-tag"></i><span>Clientes</span></a></li>
          <li><a class="" href="{{ route('tipo_cliente.index') }}"><i class="fa fa-tag"></i><span>Tipos de Cliente</span></a></li>
          <li><a class="" href="{{ route('tipo_cotacao.index') }}"><i class="fa fa-tag"></i><span>Tipos de Cotação</span></a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="fa fa-folder-open"></i>
                      <span>Relatórios Gérais</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="{{ route('report_geral_produto') }}"><i class="fa fa-file-text"></i>Produtos</a></li>
          <li><a class="" href="{{ route('rg_fornecedores') }}"><i class="fa fa-file-text"></i>Fornecedores</a></li>
          <li><a class="" href="{{ route('rg_clientes') }}"><i class="fa fa-file-text"></i>Clientes</a></li>
          <li><a class="" href="{{ route('rg_entradas') }}"><i class="fa fa-file-text"></i>Entradas</a></li>
          <li><a class="" href="{{ route('rg_saidas') }}"><i class="fa fa-file-text"></i>Saídas</a></li>
          <li><a class="" href="{{ route('rg_cotacoes') }}"><i class="fa fa-file-text"></i>Cotações</a></li>
        </ul>
      </li>

    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>
<!--sidebar end-->
