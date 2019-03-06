@extends('layouts.app')

@section('content')

<style>
     
      @media screen and (max-width: 480px) {
        .rwd_hide{
            display: none !important;
        }
      
      }


</style>


<section class="content-header">
    <h1>
      <small>寶物申報</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">寶物申報</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('treasure/add')}}">新增</button>
            @if(strpos(Auth::user()->role_id, '3') !== false||strpos(Auth::user()->role_id, '4'))
            <a href="{{url('treasure/reminder')}}"  class="btn btn-info" target="_blank">催繳名單</a>
            @endif
            <a href="https://docs.google.com/document/d/1YiLQMCMtqUoajk6CQeJG5QI8_qGDEm4Ac4LOBDtZ5Vw/edit" target="_blank" style="float: right;">說明文件</a>
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

         
                <div class="box-body">
                    <form id='nextform' class="form-horizontal" action="{{url('note/create-view')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>流水號</th>
                                    <th class="rwd_hide">Boss</th>
                                    <th>日期</th>
                                    <th>寶物名稱</th>
                                    <th class="rwd_hide">持有人</th>
                                    <th class="rwd_hide">參與人員</th>
                                    <th>是否參與</th>
                                    <th>補登倒數</th>
                                    <th class="rwd_hide">申請人</th>
                                    <th class="rwd_hide">申請時間</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($treasures as $key => $value)
                                <tr>
                                    <td><a href="{{url('treasure/info').'/'.$value->id}}">{{$value->no}}</a></td>
                                    <td class="rwd_hide">{{$boss_list[$value->boss_id]}}</td>
                                    <td>{{$value->day}}</td>
                                    <td>{{$value->item}}</td>
                                    <td class="rwd_hide">{{$value->owner_name->name}}</td>
                                    <td class="rwd_hide">
                                        @if(mb_strlen($value->d_string,'utf8')>6)
                                          <a onclick='show_note("{{$key}}")' style="cursor: pointer;">{!!mb_substr($value->d_string,0,6,'utf8')!!}...</a>
                                        @else
                                          {!!$value->d_string!!}
                                        @endif
                                    </td>
                                    <td>
                                        @if($value->is_join)
                                            Y
                                        @endif
                                    </td>
                                    <td>
                                        @if($value->show_time)
                                        <span class="btn-danger clock" tag="{{date('Y-m-d H:i:s',strtotime($value->created_at . '+1 days'))}}"></span>
                                        @endif
                                    </td>
                                    <td class="rwd_hide">{{$value->user->name}}</td>
                                    <td class="rwd_hide">{{$value->created_at}}</td>
                                    
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>

          
            </div>
        </div>

    </div>
    
</section>

<div class="modal fade" id="modal-default" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">參與人員</h4>
      </div>
      <div class="modal-body">
        <p>One fine body…</p>
      </div>
     
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


@endsection
@section('script')

 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<link rel="stylesheet" href="/dist/css/chosen.min.css">
<link rel="stylesheet" href="/dist/css/multi-select.css">
<link rel="stylesheet" href="/dist/css/jquery-ui-timepicker-addon.css">


<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.quicksearch.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script src="/dist/js/chosen.jquery.min.js"></script>
<script src="/dist/js/jquery-ui-timepicker-addon.js"></script>
<script>

   

    var treasures = <?php echo json_encode($treasures); ?>;
    $('#table').DataTable(
    {
        "order": [[ 7, "desc" ]],
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });
   
    $.each($('.clock'),function(k,v){
        var t = $(v).attr('tag');
        $(v).countdown(t, function(event) {
            $(this).html(event.strftime('%H:%M:%S'));
         });
    });

    function show_note(str)
    {

        var s = treasures[str].d_string;
        var html= '<pre>'+s+'</pre>';
        $('#modal-default .modal-body').empty().append(html);
        $('#modal-default').modal('show');

    }

   
</script>


@endsection