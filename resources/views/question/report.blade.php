@extends('layouts.app')

@section('content')


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
                @foreach($rt_data as $key => $value)
                    <div class="col-lg-6">
                        <canvas  id="{{$key}}"></canvas>
                    </div>
                @endforeach
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
</section>



@endsection
@section('script')




<link rel="stylesheet" href="/dist/css/chosen.min.css">
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.quicksearch.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script src="/dist/js/chosen.jquery.min.js"></script>
<script src="http://www.chartjs.org/dist/2.7.2/Chart.bundle.js"></script>
<script src="http://www.chartjs.org/samples/latest/utils.js"></script>



<script>
    var rt_data =  <?php echo json_encode($rt_data); ?>;
    var color = Chart.helpers.color;
    var type_color =[];
    type_color['王族'] = window.chartColors.purple;
    type_color['騎士'] = window.chartColors.blue;
    type_color['妖精'] = window.chartColors.green;
    type_color['法師'] = window.chartColors.yellow;
    type_color['不會到'] = window.chartColors.grey;
   


    var barChartData =[];
    $.each(rt_data,function(k,v){
        var index = 0;
        var obj_datasets=[];
        $.each(v,function(kk,vv){
            var c_datasets={
                label:kk,
                backgroundColor:type_color[kk],
                borderWidth:1,
                data:[v[kk].length]
            }
            obj_datasets[index]=c_datasets;
            index = index +1;
        });
        barChartData[k]={
                labels:[k],
                datasets:obj_datasets
        }
    });
    
     var zz = {
            labels: ['美麗島風雲'],
            datasets: [{
                    label: '王族',
                    backgroundColor: color(window.chartColors.purple).alpha(0.5).rgbString(),
                    borderWidth: 1,
                    data: [1]
                }, {
                    label: '騎士',
                    backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                    borderWidth: 1,
                    data: [20]
                },{
                    label: '妖精',
                    backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
                    borderWidth: 1,
                    data: [20]
                },{
                    label: '法師',
                    backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(), 
                    borderWidth: 1,
                    data: [20]
                },{
                    label: '不會到',
                    backgroundColor: color(window.chartColors.grey).alpha(0.5).rgbString(), 
                    borderWidth: 1,
                    data: [2]
                }
            ]
        };
    
        window.onload = function() {
            @foreach($rt_data as $key => $value)
                
                var ctx = document.getElementById('{{$key}}').getContext('2d');
                    window.myBar = new Chart(ctx, {
                    type: 'bar',
                    data: barChartData['{{$key}}'],
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: '{{$key}}'
                        }
                    }
                });
               
            @endforeach
         };
           



      
</script>


@endsection