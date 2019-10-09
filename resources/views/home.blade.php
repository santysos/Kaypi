@extends('adminlte::page')

@section('title', 'Kaypi v1.0')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                    <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Bienvenido a Kaypi </h3>
                              <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                              </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <!-- Apply any bg-* class to to the info-box to color it -->
                                  <div class="info-box bg-blue">
                                      <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                                      <div class="info-box-content">
                                          <span class="info-box-text">Ventas del Mes</span>
                                          <span class="info-box-number">$ {{$ventassumadas}}</span>
                          
                                          <!-- The progress section is optional -->
                                          <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                          </div>
                                        <span class="progress-description">{{$mes}}</span>
                                      </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <!-- Apply any bg-* class to to the info-box to color it -->
                                  <div class="info-box bg-red">
                                      <span class="info-box-icon"><i class="fa fa-shopping-bag"></i></span>
                                      <div class="info-box-content">
                                          <span class="info-box-text">Compras del Mes</span>
                                          @foreach ($totales as $total) 
                                                        <span class="info-box-number">$ <?php echo $total->totalingreso;?></span>
                                                        @endforeach
                                          
                                          <!-- The progress section is optional -->
                                          <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                          </div>
                                        <span class="progress-description">{{$mes}}</span>
                                      </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div>
                              <!--  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                  <div class="info-box bg-yellow">
                                      <span class="info-box-icon"><i class="fa fa-shopping-basket"></i></span>
                                      <div class="info-box-content">
                                          <span class="info-box-text">Productos</span>
                                          <span class="info-box-number">41,410</span>
                                          
                                          <div class="progress">
                                            <div class="progress-bar" style="width: 70%"></div>
                                          </div>
                                        <span class="progress-description">70% Increase in 30 Days</span>
                                      </div>
                                  </div> 
                                </div>-->
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <!-- Apply any bg-* class to to the info-box to color it -->
                                  <div class="info-box bg-green">
                                      <span class="info-box-icon"><i class="fa fa-users"></i></span>
                                      <div class="info-box-content">
                                          <span class="info-box-text">Ultimo cliente</span>
                                          <span class="info-box-number">{{$persona->nombre_comercial}}</span>
                                          <!-- The progress section is optional -->
                                          <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                          </div>
                                        <span class="label label-default"><a href="{{$persona->email}}">{{$persona->email}}</a></span>
                                      </div><!-- /.info-box-content -->
                                  </div><!-- /.info-box -->
                                </div>
                            </div><!-- /.box-body -->
                          </div><!-- /.box -->
                          
                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                              <div class="box-header with-border">
                                <h3 class="box-title">Ventas - Diarias</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->               
                                  <div class="box-body">
                                    <div class="chart">
                                      <canvas id="barChart" style="height:230px"></canvas>
                                    </div>
                                  </div>                           
                            </div>
                          </div>
                          
                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                              <div class="box-header with-border">
                                <h3 class="box-title">Ultimas 10 Ventas</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->
                              <div class="box-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead> 
                                  <th>Fecha</th>
                                  <th>Cliente</th>
                                  <th>Comprobante</th>
                                  <th>Total</th>
                                  <th>Opciones</th>
                                </thead>
                                @foreach ($ventas as $cat)
                                <tr>
                                  <td>{{ $cat->created_at}}</td>
                                  <td>{{ $cat->nombre_comercial}}</td>
                                  <td>{{ $cat->tipo_comprobante.': #'.$cat->num_comprobante}}</td>
                                  <td>$ {{ $cat->total_venta}}</td>
                                  <td>
                                    <a href="{{URL::action('VentaController@show',$cat->idtb_venta)}}"><button class="btn-xs btn btn-primary ">Detalles</button></a>
                                    </a>
                                  </td>
                                </tr>
                                @endforeach
                                </table>
                               </div>
                             </div>
                            </div>
                          </div>
                          
                          
                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                              <div class="box-header with-border">
                                <h3 class="box-title">Ventas - Meses</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->               
                                  <div class="box-body">
                                    <div class="chart">
                                      <canvas id="lineChart" style="height:250px"></canvas>
                                    </div>
                                  </div>                              
                            </div>
                          </div>
                          
                          <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-danger">
                              <div class="box-header with-border">
                                <h3 class="box-title">Compras - Meses</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->               
                                  <div class="box-body">
                                    <div class="chart">
                                      <canvas id="areaChart" style="height:250px"></canvas>
                                    </div>
                                  </div>                              
                            </div>
                          </div>
                          
                          <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-warning">
                              <div class="box-header with-border">
                                <h3 class="box-title">Nuevos Productos</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->
                              <div class="box-body">
                          
                                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                  <th>Producto</th>
                                  <th>Código</th>
                                        <th>Categoria</th>
                                  <th>Stock</th>
                                  <th>Imagen</th>
                                  
                                </thead>
                                @foreach ($articulos as $cat)
                                <tr>
                                  <td>{{ $cat->nombre}}</td>
                                  <td>{{ $cat->codigo}}</td>    
                                          <td>{{ $cat->categoria}}</td>
                                  <td>{{ $cat->stock}}</td>
                                  <td>
                                    <img src="{{asset('img/productos/'.$cat->imagen)}}" alt="{{$cat->nombre}}" height="38px" width="38px" class="img-thumbnail">
                                  </td>
                                  
                                </tr>
                                @include('almacen.articulo.modal')
                                @endforeach
                                </table>
                              </div>
                          
                              </div><!-- /.box-body -->
                            </div><!-- /.box -->
                          </div>
                          
                          <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                              <div class="box-header with-border">
                                <h3 class="box-title">Más Vendidos</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->               
                                  <div class="box-body">
                                    <div class="chart">
                                      <canvas id="pieChart" style="height:250px"></canvas>
                                    </div>
                                  </div>                           
                            </div>
                          </div>
                          
                          <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                              <div class="box-header with-border">
                                <h3 class="box-title">Mas Frecuentes</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->
                              <div class="box-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead> 
                                  
                                  <th>Posición</th>       
                                  <th>Productos</th>
                                  <th># Ventas</th>
                                </thead>
                                <?php   $contador = 1; ?>
                                @foreach ($masvendidos as $cat)
                                <tr>
                                  <td><?php     echo $contador;?></td>
                                  <td>{{ $cat->nombre}}</td>
                                  <td>{{ $cat->mejores}}</td>
                                  
                                </tr><?php  ++$contador; ?>
                                @endforeach
                                </table>
                              </div><!-- /.box-body -->
                            </div><!-- /.box -->
                          </div>
                          </div>
                          
                          <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-success">
                              <div class="box-header with-border">
                                <h3 class="box-title">Mejores Clientes</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                              </div><!-- /.box-header -->
                              <div class="box-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead> 
                                  <th>Posición</th>
                                  <th>Cliente</th>
                                  <th># Compras</th>
                                  <th>Total</th>
                                  
                                </thead>
                                <?php   $contador = 1; ?>
                                @foreach ($mejoresclientes as $cat)
                                <tr>
                                  <td><?php     echo $contador;?></td>
                                  <td>{{ $cat->nombre_comercial}}</td>
                                  <td>{{ $cat->mejores}}</td>
                                  <td>$ {{ $cat->sumventas}}</td>       
                                </tr><?php  ++$contador; ?>
                                @endforeach
                                </table>
                              </div><!-- /.box-body -->
                            </div><!-- /.box -->
                          </div>
                          </div>
                          
                          
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
<script src="{{asset('js/Chart.js')}}"></script>

    <script>
      $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas);

        var ComprasMes = {
          labels: [<?php foreach ($comprasmes as $reg)
                {echo '"'. $reg->mes.'",';} ?>],
          datasets: [
            {
              label: "Electronics",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: []
            },
            {
              label: "Digital Goods",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.8)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: [<?php foreach ($comprasmes as $reg)
                {echo ''. $reg->totalmes.',';} ?>]
            }
          ]
        };

        var VentasMes = {
          labels: [<?php foreach ($ventasmes as $reg)
                {echo '"'. $reg->mes.'",';} ?>],
          datasets: [
            {
              label: "Electronics",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: []
            },
            {
              label: "Digital Goods",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.8)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: [<?php foreach ($ventasmes as $reg)
                {echo ''. $reg->totalmes.',';} ?>]
            }
          ]
        };

        var VentasDias = {
          labels: [<?php foreach ($ventasdia as $reg)
                {echo '"'. $reg->dia.'",';} ?>],
          datasets: [
            {
              label: "Electronics",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: []
            },
            {
              label: "Digital Goods",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.8)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: [<?php foreach ($ventasdia as $reg)
                {echo ''. $reg->totaldia.',';} ?>]
            }
          ]
        };

        var areaChartOptions = {
          //Boolean - If we should show the scale at all
          showScale: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: false,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - Whether the line is curved between points
          bezierCurve: true,
          //Number - Tension of the bezier curve between points
          bezierCurveTension: 0.3,
          //Boolean - Whether to show a dot for each point
          pointDot: false,
          //Number - Radius of each point dot in pixels
          pointDotRadius: 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth: 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius: 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke: true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth: 2,
          //Boolean - Whether to fill the dataset with a color
          datasetFill: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true
        };

        //Create the line chart
        areaChart.Line(ComprasMes, areaChartOptions);

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        lineChart.Line(VentasMes, lineChartOptions);

        
        var lineChartCanvas = $("#barChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        lineChart.Line(VentasDias, lineChartOptions);
        



        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
          <?php 
            $cont=1;
            $cadena='';

            foreach ($productosvendidos as $reg)
                       {
                        $cadena=$cadena.'{ value:'.$reg->cantidad.',color:"';
                       switch($cont)
                       {
                        case 1:
                            $color='#f56954';
                            break;
                        case 2:
                            $color='#00a65a';
                            break;
                        case 3:
                            $color='#f39c12';
                            break;
                        case 4:
                            $color='##00c0ef';
                            break;
                        case 5:
                            $color='##3c8dbc';
                            break;
                        case 6:
                            $color='##d2d6de';
                            break;
                        case 7:
                            $color='#8B008B';
                            break;
                        case 8:
                            $color='#FF8C00';
                            break;
                        case 9:
                            $color='#696969';
                            break;
                        case 10:
                            $color='#ADFF2F';
                            break;
                       }

                       $cadena=$cadena.$color;
                       $cadena=$cadena.'",highlight: "';
                       $cadena=$cadena.$color.'",label: "'.$reg->articulo.'" },';
                       $cont=$cont+1;
                       }
            echo $cadena;?>
        ];
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);

        //-------------
        //- BAR CHART -
        //-------------
       /* var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = VentasDias;
        barChartData.datasets[1].fillColor = "#00a65a";
        barChartData.datasets[1].strokeColor = "#00a65a";
        barChartData.datasets[1].pointColor = "#00a65a";
        var barChartOptions = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - If there is a stroke on each bar
          barShowStroke: true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth: 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing: 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing: 1,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to make the chart responsive
          responsive: true,
          maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);*/
      });

      $('#liEstadistica').addClass("treeview active");
      $('#liEscritorio').addClass("active");


    </script>
@stop
