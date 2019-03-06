@extends('layouts.app')

@section('content')

<section class="content-header">
    <h1><small>{{$user_id}} - 積分明細表</small></h1>
    <ol class="breadcrumb">
      <li>
        <a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a>
      </li>
      <li class="active">
        <a href="{{url('rank/index')}}">積分表</a>
      </li>
      <li class="active">積分明細表</li>
    </ol>
</section>





<section class="content">

    <div class="row">
        <div class="col-md-12">


  
    <!-- Custom tabs (Charts with tabs)-->
    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right ui-sortable-handle">
        
      
        
        <li class="">
          <a aria-expanded="false" data-toggle="tab" href="#other-info">其他積分<label style='color:red'>({{$other_sum}})</label></a>
        </li>
        <li class="">
          <a aria-expanded="false" data-toggle="tab" href="#castle-info">守城積分<label style='color:red'>({{$castle_sum}})</label></a>
        </li>
        <li class="">
          <a aria-expanded="false" data-toggle="tab" href="#killer-info">出草積分<label style='color:red'>({{$killer_sum}})</label></a>
        </li>
        <li class="active">
          <a aria-expanded="true" data-toggle="tab" href="#treasure-info">打寶積分<label style='color:red'>({{$treasure_sum}})</label></a>
        </li>
        <li class="pull-left header"><i class="fa fa-inbox"></i>積分明細表</li>
      </ul>
      <div class="tab-content no-padding">
        <!-- Morris chart - Sales -->
        <div class="tab-pane active" id="treasure-info">
                <div class="box-body">
                   
                        <table id="treasure_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>寶物單號</th>
                                    <th>日期</th>
                                    <th>物品</th>
                                    <th>收入</th>
                                    <th>所得積分(*1)</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($treasure_table as $key => $value)
                                <tr>
                                   
                                    <td><a href='{{url('rank/treasure-info/'.$value->id)}}'>{{$value->no}}</a></td>
                                    <td>{{$value->day}}</td>
                                    <td>{{$value->item}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->amount*1}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   
                </div>
        </div>
        <div class="tab-pane" id="killer-info">
           <div class="box-body">
                   
                        <table id="killer_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>日期</th>
                                    <th>項目</th>
                                    <th>收入</th>
                                    <th>所得積分(*1.3)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($killer_table as $key => $value)
                                <tr>
                                   
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->source_type}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->amount*1.3}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   
                </div>
        </div>
        <div class="tab-pane" id="castle-info">
             <div class="box-body">
                   
                        <table id="castle_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>日期</th>
                                    <th>項目</th>
                                    <th>收入</th>
                                    <th>所得積分(*3)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($castle_table as $key => $value)
                                <tr>
                                   
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->source_type}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->amount*3}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   
                </div>
        </div>
        <div class="tab-pane" id="other-info">
            <div class="box-body">
                   
                        <table id="other_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>日期</th>
                                    <th>項目</th>
                                    <th>所得積分</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($other_table as $key => $value)
                                <tr>
                                   
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->source_type}}</td>
                                    <td>{{$value->amount}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   
            </div>

        </div>
      </div>
    </div><!-- /.nav-tabs-custom -->
    <!-- Chat box -->
    

 </div>
    </div><!-- /.nav-tabs-custom -->

  </section>








  


@endsection
@section('script')
<script>

  
    // $('#table').DataTable(
    // {
    //   "iDisplayLength": 50,
    //   'paging'      : true,
    //   'lengthChange': true,
    //   'searching'   : true,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false,
    //   "order": [[ 5, "desc" ]]
    // });
   

 
   
</script>


@endsection