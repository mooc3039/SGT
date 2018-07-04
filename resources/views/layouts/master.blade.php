<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Sistema de Gestão de Stocks">
  <meta name="author" content="M2OC -Dev. Ltd.">
  <meta name="keyword" content="Gestão, Stock, Faturação, Produtos, Encomendas">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>SG-Stock Administração</title>



  {!!Html::style('css/sgt.css')!!}
  
  <!-- {!!Html::style('/datatable/datatables.bootstrap.css')!!} -->
  <!-- {!!Html::style('/datatable/bootstrap.min.css')!!} -->
  
  {!!Html::style('css/bootstrap.min.css')!!}<!-- versão 3.3.7 -->
  <!-- {!!Html::style('css/jquery.dataTables.min.css')!!}  -->
  {!!Html::style('css/dataTables.bootstrap.min.css')!!} <!-- DataTables Funcionando 01-04-2018 -->
  {!!Html::style('css/bootstrap-theme.min.css')!!}
  {!!Html::style('css/elegant-icons-style.css')!!}
  {!!Html::style('css/font-awesome.min.css')!!}
  {!!Html::style('assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css')!!}
  {!!Html::style('assets/fullcalendar/fullcalendar/fullcalendar.css')!!}
  {!!Html::style('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')!!}
  {!!Html::style('css/owl.carousel.css')!!}
  {!!Html::style('css/jquery-jvectormap-2.0.3.css')!!}
  {!!Html::style('css/fullcalendar.css')!!}
  {!!Html::style('css/widgets.css')!!}
  {!!Html::style('css/style.css')!!}
  {!!Html::style('css/style-responsive.css')!!}
  {!!Html::style('css/xcharts.min.css')!!}
  {!!Html::style('css/jquery-ui-1.10.4.min.css')!!}
  {!!Html::style('css/select2.min.css')!!}

  <!--  {!! Charts::styles() !!}  -->
  @yield('style')
  <style type="text/css">
  .wait {
    background-color: #ccc;
    text-align: center;
    z-index: 100;
    display:none;
    width:100%;
    height:100%;
    position:absolute;
    top:0;
    left:0;
    padding:5px;
    opacity: 0.6;
  }
  .wait-loader{
    position:absolute;
    left:50%;
    top:50%;
    font-size: 50px;
    color: red;
  }


</style>

</head>
<body>




  {!!Html::script('js/jquery.js')!!}
  {!!Html::script('js/jquery-ui-1.10.4.min.js')!!}
  {!!Html::script('js/jquery.dataTables.min.js')!!} <!-- DataTables Funcionando 01-04-2018 -->
  {!!Html::script('js/dataTables.buttons.min.js')!!} <!-- DataTables Buttons Funcionando 01-04-2018 -->
  {!!Html::script('js/buttons.print.min.js')!!} <!-- DataTables print Funcionando 01-04-2018 -->
  {!!Html::script('js/jszip.min.js')!!} <!-- DataTables print Funcionando 01-04-2018 -->
  {!!Html::script('js/pdfmake.min.js')!!} <!-- DataTables print Funcionando 01-04-2018 -->
  {!!Html::script('js/vfs_fonts.js')!!} <!-- DataTables print Funcionando 01-04-2018 -->
  {!!Html::script('js/buttons.html5.min.js')!!} <!-- DataTables print Funcionando 01-04-2018 -->
  {!!Html::script('js/dataTables.bootstrap.min.js')!!} <!-- DataTables Funcionando 01-04-2018 -->

  
  <!-- {!!Html::script('/datatable/jquery.min.js')!!} -->  <!--jQuery v2.1.3 -->
  <!--  {!!Html::script('js/jquery-3.2.1.min.js')!!} -->
  {!!Html::script('js/jquery-ui-1.9.2.custom.min.js')!!}
  {!!Html::script('js/bootstrap.min.js')!!} <!-- versão 3.3.7  -->

  
  <!--    {!!Html::script('/datatable/bootstrap.min.js')!!}  --> <!-- Bootstrap v3.3.4 -->

  <!-- {!!Html::script('/datatable/jquery.dataTables.min.js')!!} --><!-- DataTables 1.10.9 -->
  <!-- {!!Html::script('/datatable/datatables.bootstrap.js')!!} --> <!-- DataTables 1.10  -->

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
  {!!Html::script('js/jquery-jvectormap-2.0.3.min.js')!!}
  {!!Html::script('js/jquery-jvectormap-world-mill-en.js')!!}
  {!!Html::script('js/xcharts.min.js')!!}
  {!!Html::script('js/jquery.autosize.min.js')!!}
  {!!Html::script('js/jquery.placeholder.min.js')!!}
  {!!Html::script('js/gdp-data.js')!!}
  {!!Html::script('js/morris.min.js')!!}
  {!!Html::script('js/sparklines.js')!!}
  <!--  {!!Html::script('js/charts.js')!!} -->
  {!!Html::script('js/jquery.slimscroll.min.js')!!}
  {!!Html::script('js/select2.min.js')!!}
  {!!Html::script('js/bootstrap-confirmation.min.js')!!}
  {!!Html::script('js/jquery.printPage.js')!!}







  <section id="container" class="">
    <!-- <table class="mostrar">
    <thead>
      <th>Nome</th>
      <th>Apelido</th>
      <th>Mae</th>
      <th>Pai</th>
    </thead>
    <tbody>
      <tr>
        <td>Osorio</td>
        <td>Malache</td>
        <td>Gilda</td>
        <td>Malace</td>
      </tr>
      <tr>
        <td>Leo</td>
        <td>Malache</td>
        <td>Gilda</td>
        <td>Malace</td>
      </tr>
    </tbody>
  </table> -->

  @include('layouts.processing.processing')
  @include('layouts.header.header')
  @include('layouts.sidebars.sidebar')

  <section id="main-content">
    <div class="wrapper">

      @include('layouts.validation.alertas')
      @yield('content')

    </div>
  </section>

</section>
@yield('script')
<script>
  // $(document).ready(function() {
  //   var oTable = $('.mostrar').DataTable( {
  //     "pagingType": "full_numbers",
  //     "dom": 'Brtpl',
  //     buttons: [
  //           // 'print',
  //           // 'excelHtml5',
  //           // 'pdfHtml5'
  //           {
  //             text: 'Imprimir',
  //             extend: 'print',
  //             className: 'btn btn-defaul btn-sm'
  //           },
  //           {
  //             text: 'Excel',
  //             extend: 'excelHtml5',
  //             className: 'btn btn-defaul btn-sm'
  //           },
  //           {
  //             text: 'PDF',
  //             extend: 'pdfHtml5',
  //             className: 'btn btn-defaul btn-sm'
  //           }
  //           ]
  //         });

  //   $('#pesq').keyup(function(){
  //     oTable.search($(this).val()).draw();
  //   });
  // } );

  /** SEARCH SELECT */
  $(document).ready( function() {
    $('.select_search').select2();
  });
  /* FIM SEARCH SELECT */

      //====
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

        $(document).ready(function(){
          $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
          });
          $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
          });
        });

        //custom select box

        // $(function() {
        //   $('select.styled').customSelect();
        // });

        /* ---------- Map ---------- */
/*         $(function() {
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
        */

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

        function numberOnly(input){
          $(input).keypress(function(evt){
            var e = event || evt;
            var charCode = e.which || e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
              return false;
            return true;
          });
        }

        // ==== formatando os numeros para 0.000,00 ====
        // Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
        //   var n = this,
        //   decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        //   decSeparator = decSeparator == undefined ? ".": decSeparator,
        //   thouSeparator = thouSeparator == undefined ? ",": thouSeparator,
        //   sign = n < 0 ? "-" : "",
        //   i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
        //   j = (j = i.length) > 3 ? j % 3 : 0;
        //   return sign + (j ? i.substr(0,j) + thouSeparator : "")
        //   + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
        //   + (decPlaces ? decSeparator + Math.abs(n-i).toFixed(decPlaces).slice(2) : "");
        // };

            Number.prototype.formatMoney = function(places, symbol, thousand, decimal) {
  places = !isNaN(places = Math.abs(places)) ? places : 2;
  symbol = symbol !== undefined ? symbol : "";
  thousand = thousand || ",";
  decimal = decimal || ".";
  var number = this, 
      negative = number < 0 ? "-" : "",
      i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
      j = (j = i.length) > 3 ? j % 3 : 0;
  return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
};



      </script>
    </body>
    </html>
