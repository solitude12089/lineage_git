@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>入帳作業</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">入帳作業</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
       
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                            <li class="">
                              <a aria-expanded="false" data-toggle="tab" href="#history-list">歷史紀錄</a>
                            </li>
                            <li class="active">
                              <a aria-expanded="true" data-toggle="tab" href="#treasures-list">寶物清單</a>
                            </li>
                            
                            <li class="pull-left header"><i class="fa fa-inbox"></i>入帳寶物清單</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="tab-pane active" id="treasures-list">
                            <div class="box-body">
                                <table id="table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            
                                            <th>流水號</th>
                                            <th>Boss</th>
                                            <th>日期</th>
                                            <th>寶物名稱</th>
                                            <th>持有人</th>
                                            <th>參與人員</th>
                                            <th>申請人</th>
                                            <th>申請時間</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($treasures as $key => $value)
                                        <tr>
                                            <td><a href="{{url('import/info').'/'.$value->id}}">{{$value->no}}</a></td>
                                            <td>{{$boss_list[$value->boss_id]}}</td>
                                            <td>{{$value->day}}</td>
                                            <td>{{$value->item}}</td>
                                            <td>{{$value->owner_name->name}}</td>
                                            <td>
                                                @if(mb_strlen($value->d_string,'utf8')>6)
                                                  <a onclick='show_note("{{$key}}")' style="cursor: pointer;">{!!mb_substr($value->d_string,0,6,'utf8')!!}...</a>
                                                @else
                                                  {!!$value->d_string!!}
                                                @endif
                                            </td>
                                            <td>{{$value->user->name}}</td>
                                            <td>{{$value->created_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="history-list">
                            <div class="box-body">
                                <table id="history_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            
                                            <th>流水號</th>
                                            <th>Boss</th>
                                            <th>日期</th>
                                            <th>寶物名稱</th>
                                            <th>持有人</th>
                                            <th>參與人員</th>
                                            <th>申請人</th>
                                            <th>申請時間</th>
                                            <th>覆核者</th>
                                            <th>覆核時間</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($history_treasures as $key => $value)
                                        <tr>
                                            <td><a href="{{url('import/infohistory').'/'.$value->id}}">{{$value->no}}</a></td>
                                            <td>{{$boss_list[$value->boss_id]}}</td>
                                            <td>{{$value->day}}</td>
                                            <td>{{$value->item}}</td>
                                            <td>{{$value->owner_name->name}}</td>
                                            <td>
                                                @if(mb_strlen($value->d_string,'utf8')>6)
                                                  <a onclick='show_note("{{$key}}")' style="cursor: pointer;">{!!mb_substr($value->d_string,0,6,'utf8')!!}...</a>
                                                @else
                                                  {!!$value->d_string!!}
                                                @endif
                                            </td>
                                            <td>{{$value->user->name}}</td>
                                            <td>{{$value->created_at}}</td>
                                            <td>{{$user_map[$value->assentor]}}</td>
                                            <td>{{$value->updated_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                           
                                       
                            </div>
                        </div>
                            
                    </div>
                   
                        
                    
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
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
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
    $('#history_table').DataTable(
    {
        "order": [[ 9, "desc" ]],
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
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