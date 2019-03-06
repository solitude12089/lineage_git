@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>{{$user_id}} - 打寶積分列表 <label style="color:red">Sum : {{$sum}}</label></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('rank/index')}}">積分表</a></li>
      <li class="active">打寶積分列表</li>
    </ol>
</section>

  
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

         
                <div class="box-body">
                   
                        <table id="table" class="table table-bordered table-hover">
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
                                @foreach($table as $key => $value)
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
        </div>

    </div>
    
</section>


@endsection
@section('script')
<script>

  
    $('#table').DataTable(
    {
      "iDisplayLength": 50,
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "order": [[ 5, "desc" ]]
    });
   

 
   
</script>


@endsection