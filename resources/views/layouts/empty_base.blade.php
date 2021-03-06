<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistema de Gestão de Stocks">
  <meta name="author" content="M2OC -Dev. Ltd.">
  <meta name="keyword" content="Gestão, Stock, Faturação, Produtos, Encomendas">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>SG-Stock Administração</title>
  {!!Html::style('css/bootstrap.min.css')!!}
  {!!Html::style('css/bootstrap-theme.min.css')!!}
  {!!Html::style('css/elegant-icons-style.css')!!}
  {!!Html::style('css/font-awesome.min.css')!!}
  {!!Html::style('assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css')!!}
  {!!Html::style('assets/fullcalendar/fullcalendar/fullcalendar.css')!!}
  {!!Html::style('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')!!}
  {!!Html::style('css/owl.carousel.css')!!}
  {!!Html::style('css/jquery-jvectormap-1.2.2.css')!!}
  {!!Html::style('css/fullcalendar.css')!!}
  {!!Html::style('css/widgets.css')!!}
  {!!Html::style('css/style.css')!!}
  {!!Html::style('css/style-responsive.css')!!}
  {!!Html::style('css/xcharts.min.css')!!}
  {!!Html::style('css/jquery-ui-1.10.4.min.css')!!}
  {!!Html::style('css/select2.min.css')!!}
  @yield('style')

  {!!Html::script('js/jquery.js')!!}
  {!!Html::script('js/jquery-ui-1.10.4.min.js')!!}
  {!!Html::script('js/jquery-3.2.1.min.js')!!}
  {!!Html::script('js/jquery-ui-1.9.2.custom.min.js')!!}
  {!!Html::script('js/bootstrap.min.js')!!}
  {!!Html::script('js/jquery.scrollTo.min.js')!!}
  {!!Html::script('js/jquery.nicescroll.js')!!}
  {!!Html::script('assets/jquery-knob/js/jquery.knob.js')!!}
  {!!Html::script('js/jquery.sparkline.js')!!}
  {!!Html::script('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')!!}
  {!!Html::script('js/owl.carousel.js')!!}
  {!!Html::script('js/fullcalendar.min.js')!!}
  {!!Html::script('assets/fullcalendar/fullcalendar/fullcalendar.js')!!}
  {!!Html::script('js/calendar-custom.js')!!}
  {!!Html::script('js/jquery.rateit.min.js')!!}
  {!!Html::script('js/jquery.customSelect.min.js')!!}
  {!!Html::script('assets/chart-master/Chart.js')!!}
  {!!Html::script('js/scripts.js')!!}
  {!!Html::script('js/sparkline-chart.js')!!}
  {!!Html::script('js/easy-pie-chart.js')!!}
  {!!Html::script('js/jquery-jvectormap-1.2.2.min.js')!!}
  {!!Html::script('js/jquery-jvectormap-world-mill-en.js')!!}
  {!!Html::script('js/xcharts.min.js')!!}
  {!!Html::script('js/jquery.autosize.min.js')!!}
  {!!Html::script('js/jquery.placeholder.min.js')!!}
  {!!Html::script('js/gdp-data.js')!!}
  {!!Html::script('js/morris.min.js')!!}
  {!!Html::script('js/sparklines.js')!!}
  {!!Html::script('js/charts.js')!!}
  {!!Html::script('js/jquery.slimscroll.min.js')!!}
  {!!Html::script('js/select2.min.js')!!}
</head>
  <body>

    <section class="">
      @include('layouts.validation.alertas')
          @yield('content')
      </section>



    @yield('script')
      <script>
      //====

      /* SEARCH SELECT */
      $(document).ready( function() {
        $('.select_search').select2();
      });
      /* FIM SEARCH SELECT */
      
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      });

        //knob
        $(function() {
          $(".knob").knob({
            'draw': function() {
              $(this.i).val(this.cv + '%')
            }
          })
        });

        //carousel
        $(document).ready(function() {
          $("#owl-slider").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true

          });
        });

        //custom select box

        $(function() {
          $('select.styled').customSelect();
        });

        /* ---------- Map ---------- */
        $(function() {
          $('#map').vectorMap({
            map: 'world_mill_en',
            series: {
              regions: [{
                values: gdpData,
                scale: ['#000', '#000'],
                normalizeFunction: 'polynomial'
              }]
            },
            backgroundColor: '#eef3f7',
            onLabelShow: function(e, el, code) {
              el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
            }
          });
        });
      </script>
  </body>
  <script type="text/javascript">

    //====trocar de focus para o proximo campo a preencher
    $('tbody').delegate('.descricao','change', function(){
      var tr = $(this).parent().parent();
      tr.find('.quantidade').focus();
    });

    //======pegar os valores dos campos e calcular o valor de cada produto====
      $('tbody').delegate('.quantidade,.preco_venda,.desconto','keyup',function(){
        var tr = $(this).parent().parent();
        var quantidade = tr.find('.quantidade').val();
        var preco_venda = tr.find('.preco_venda').val();
        var desconto = tr.find('.desconto').val();
        var subtotal = (quantidade*preco_venda)-(quantidade*preco_venda*desconto)/100;
        tr.find('.subtotal').val(subtotal);
        total();
      });

      //==calculo do total de todas as linhas
        function total()
        {
          var total =0;
          $('.subtotal').each(function(i,e){
            var subtotal = $(this).val()-0;
            total +=subtotal;
          })
          $('.total').html(total.formatMoney(2,',','.')+ " Mtn");
        };

        // ==== formatando os numeros ====
        Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
          var n = this,
              decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
              decSeparator = decSeparator == undefined ? ".": decSeparator,
              thouSeparator = thouSeparator == undefined ? ",": thouSeparator,
              sign = n < 0 ? "-" : "",
              i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
              j = (j = i.length) > 3 ? j % 3 : 0;
              return sign + (j ? i.substr(0,j) + thouSeparator : "")
              + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
              + (decPlaces ? decSeparator + Math.abs(n-i).toFixed(decPlaces).slice(2) : "");
        };
//---começam aqui as funçoes que filtram somente números
          //---find element by row--
          function findRowNum(input){
            $('tbody').delegate(input, 'keydown',function(){
              var tr =$(this).parent().parent();
              number(tr.find(input));
            });
          }

          function findRowNumOnly(input){
            $('tbody').delegate(input, 'keydown',function(){
              var tr =$(this).parent().parent();
              numberOnly(tr.find(input));
            });
          }

      //--numeros e pontos
      function number(input){
        $(input).keypress(function (evt){
          var theEvent = evt || window.event;
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode( key );
          var regex = /[-\d\.]/;
          var objRegex = /^-?\d*[\.]?\d*$/;
          var val = $(evt.target).val();
          if(!regex.test(key) || !objRegex.test(val+key) ||
            !theEvent.keyCode == 46 || !theEvent.keyCode == 8){
              theEvent.returnValue = false;
              if(theEvent.preventDefault) theEvent.preventDefault();
            };
        });
      };
        function findRowNumOnly(input){
          $('tbody').delegate(input, 'keydown',function(){
            var tr =$(this).parent().parent();
            numberOnly(tr.find(input));
          });
        }
        //-------------somente numeros
            function numberOnly(input){
              $(input).keypress(function(evt){
                var e = event || evt;
                var charCode = e.which || e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
                return true;
              });
            }
         //---limitando somente para entrada de números
         findRowNum('.quantidade');
         findRowNum('.preco_venda');
         findRowNum('.desconto');


  //------devolver dados do price
      $('tbody').delegate('.descricao','change',function(){
        var tr= $(this).parent().parent();
        var id = tr.find('.descricao').val();
        var dataId={'id':id};
        $.ajax({
          type  : 'GET',
          url   : '{!!URL::route('findPrice')!!}',
          dataType: 'json',
          data  : dataId,
          success:function(data){
            tr.find('.preco_venda').val(data.preco_venda);
          }
        });
      });

    //==========adiciona mais uma linha da usando a função addRow==
    $('.addRow').on('click',function(){
      addRow();
    });

    //====remove a linha adicionada, foram corrigidos muitos bugs aqui===

    $('tbody').on('click','.remove',function(){
          var l=$('tbody tr').length;
          if (l==1) {
            alert('Não poderá remover o ultimo campo de facturação');
          }else{
          $(this).parent().parent().remove();
          total();
          }

        });


  </script>
</html>
