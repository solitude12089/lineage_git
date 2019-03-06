@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>積分表</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">積分表</li>
    </ol>
</section>

  
<section class="content">
    @if(strpos(Auth::user()->role_id, '4') !== false)
    <div class="row">
      <div class="col-md-12">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('rank/add')}}">新增領取紀錄</button>
      </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

         
                <div class="box-body">
                   
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>排名</th>
                                    <th>角色ID</th>
                                    <th>總積分</th>
                                    <th>備註</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($table as $key => $value)
                                <tr>
                                    <td>{{$value->rank}}</td>
                                    @if(in_array($value->user_id,$special))
                                       <td><a style='color:orange' href='{{url('rank/info-list/'.$value->user_id)}}'>{{$value->user_id}}</a></td>
                                    @else
                                       <td><a href='{{url('rank/info-list/'.$value->user_id)}}'>{{$value->user_id}}</a></td>
                                    @endif
                                    <td>{{$value->總積分}}</td>
                                    <td>{{$value->備註}}</td>
                                    
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
<script src="/dist/js/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="/dist/css/chosen.min.css">
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
      "order": [[ 0, "asc" ]]
    });
   

 
   
</script>


@endsection