@extends('layouts.app')

@section('content')

<style>
.chart {
  width: 100%;
  height: 500px;
}

.amcharts-export-menu-top-right {
  top: 10px;
  right: 0;
}
</style>

<section class="content-header">
    <h1>
      <small>問卷調查-報表</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/question/index')}}">問卷調查</a></li>
      <li class="active"></li>
      報表
    </ol>
</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">{{$question->title}}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div id="container">
                <div class="col-lg-6">
                    <div class="chart" id="all"></div> 
                </div>
                @foreach($rt_data as $key => $value)
                    <div class="col-lg-6">
                        <div class="chart" id="{{$key}}"></div> 
                    </div>
                @endforeach


            
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>

    <div id="chartdiv"></div>   
</section>
                


@endsection
@section('script')




<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>


<script>
    var rt_data =  <?php echo json_encode($rt_data); ?>;
    //var color = Chart.helpers.color;
    var type_color =[];
    type_color['王族'] = '#8A0CCF';
    type_color['騎士'] = '#FF0F00';
    type_color['妖精'] = '#04D215';
    type_color['法師'] = '#CD0D74';
    type_color['不會到'] = '#AAAAAA';
   


    var barChartData =[];
    $.each(rt_data,function(k,v){
        var index = 0;
        var obj_datasets=[];
        $.each(v,function(kk,vv){
            var c_datasets={
                '職業':kk,
                '顏色':type_color[kk],
                '數量':v[kk].length
            }
            obj_datasets[index]=c_datasets;
            index = index +1;
        });
        barChartData[k]=obj_datasets;
    });


    @foreach($rt_data as $key => $value)
        var chart_{{$key}} = AmCharts.makeChart("{{$key}}", {
            "type": "serial",
            "theme": "light",
            "titles": [{
                "text": "{{$key}}",
                "size": 15
            }],
            "marginRight": 70,
            "dataProvider": barChartData['{{$key}}'],
            "valueAxes": [{
                'integersOnly':true
            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<b>[[category]]: [[value]]</b>",
                "fillColorsField": "顏色",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "labelText": "[[value]]",
                "type": "column",
                "valueField": "數量"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "職業",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 0
            },

            "export": {
                "enabled": true
            }
    });
               
    @endforeach





    var chart_all = AmCharts.makeChart("all", {
  "type": "pie",
  "titles": [{
                "text": "總人數表",
                "size": 15
        },{
            "text": "填表人數:{{$qas_all}}",
            "bold": false
        }],
  "startDuration": 0,
   "theme": "light",
  "addClassNames": true,
  "legend":{
    "position":"right",
    "marginRight":100,
    "autoMargins":false
  },
  "innerRadius": "30%",
  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "feOffset": {
        "result": "offOut",
        "in": "SourceAlpha",
        "dx": 0,
        "dy": 0
      },
      "feGaussianBlur": {
        "result": "blurOut",
        "in": "offOut",
        "stdDeviation": 5
      },
      "feBlend": {
        "in": "SourceGraphic",
        "in2": "blurOut",
        "mode": "normal"
      }
    }]
  },
  "dataProvider": [{
    "country": "出席人數",
    "litres": {{$qas_yes}}
  }, {
    "country": "未到人數",
    "litres": {{$qas_not}}
  }],
  "valueField": "litres",
  "titleField": "country",
  "export": {
    "enabled": true
  }
});

chart.addListener("init", handleInit);

chart.addListener("rollOverSlice", function(e) {
  handleRollOver(e);
});

function handleInit(){
  chart.legend.addListener("rollOverItem", handleRollOver);
}

function handleRollOver(e){
  var wedge = e.dataItem.wedge.node;
  wedge.parentNode.appendChild(wedge);
}




 
      
</script>


@endsection