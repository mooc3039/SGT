<!--sidebar start-->
<aside>
  <div id="sidebar" class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu">
      <li class="active">
        <a class="" href="index.html">
                      <i class="icon_house_alt"></i>
                      <span>Administração </span>
                  </a>
      </li>
    <!--  <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="icon_document_alt"></i>
                      <span>Produtos</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="#">Gerenciar Produto</a></li>
          <li><a class="" href="#">Todos Produtos</a></li>
        </ul>
      </li>
    -->
      <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="icon_desktop"></i>
                      <span>Facturação</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="{{ route('facturar' )}}">Facturar</a></li>
          <li><a class="" href="#">Saídas</a></li>
          <li><a class="" href="#">Entradas</a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="icon_table"></i>
                      <span>Stocks</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="{{ route('indexStock') }}">Todos Produtos</a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" class="">
                      <i class="icon_documents_alt"></i>
                      <span>Parametrização</span>
                      <span class="menu-arrow arrow_carrot-right"></span>
                  </a>
        <ul class="sub">
          <li><a class="" href="{{ route('fornecedores.index') }}">Fornecedores</a></li>
          <li><a class="" href="{{ route('produtos.index') }}">Produtos</a></li>
          <li><a class="" href="{{ route('indexUsuario') }}">Usuários</a></li>
          <li><a class="" href="{{ route('cliente.index') }}"><span>Clientes</span></a></li>
        </ul>
      </li>

<!--
      <li>
        <a class="" href="#">
                      <i class="icon_genius"></i>
                      <span>Encomendas</span>
                  </a>
      </li>

      <li>
        <a class="" href="#">
                      <i class="icon_piechart"></i>
                      <span>Relatórios</span>

                  </a>

      </li>

-->



    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>
<!--sidebar end-->
