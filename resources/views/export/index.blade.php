@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>提領審核</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">提領審核</li>
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
                              <a aria-expanded="true" data-toggle="tab" href="#export-list">申請清單</a>
                            </li>
                            
                            <li class="pull-left header"><i class="fa fa-inbox"></i>提領申請清單</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="tab-pane active" id="export-list">
                            <div class="box-body">
                                <table id="table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            
                                            <th>流水號</th>
                                            <th>提領金額</th>
                                            <th>申請人</th>
                                            <th>申請時間</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exports as $key => $value)
                                        <tr>
                                            <td>{{$value->no}}</td>
                                            <td>{{$value->amount}}</td>
                                            <td>{{$value->user->name}}</td>
                                            <td>{{$value->created_at}}</td>
                                             
                                            <td>
                                                <form id='nextform_{{$value->id}}' class="form-horizontal" action="{{url('export/doconfirm'.'/'.$value->id)}}" method="post">
                                                    <input type="button" class="btn btn-success btn-xs" value="確認完成" onclick="doconfirm({{$value->id}})"/>
                                                </form>
                                            </td>
                                            <td>
                                                <form id='closeform_{{$value->id}}' class="form-horizontal" action="{{url('export/doclose'.'/'.$value->id)}}" method="post">
                                                    <input type="button" class="btn btn-danger btn-xs" value="刪除" onclick="doclose({{$value->id}})"/>
                                                </form>
                                            </td>
                                            
                                            
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
                                            <th>提領金額</th>
                                            <th>申請人</th>
                                            <th>申請時間</th>
                                            <th>覆核者</th>
                                            <th>覆核時間</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exports_history as $key => $value)
                                        <tr>
                                            <td>{{$value->no}}</td>
                                            <td>{{$value->amount}}</td>
                                            <td>{{$value->user->name}}</td>
                                            <td>{{$value->created_at}}</td>
                                            <td>{{$value->assentor}}</td>
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

  
    $('#table').DataTable(
    {
        "order": [[ 5, "desc" ]],
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });
    $('#history_table').DataTable(
    {
        "order": [[ 5, "desc" ]],
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });



    function doconfirm(id)
    {
        BootstrapDialog.show({
            message: '是否確認付款????',
            buttons: [
                {
                    label: '確定',
                    cssClass: 'btn-success',
                    action: function(dialogRef) {
                            $('#nextform_'+id).submit();
                    }
                    
                },
                {
                    label: 'Close',
                    action: function(dialogRef) {
                        dialogRef.close();
                    }
                }


            ]
        });


    }
    function doclose(id)
    {
        BootstrapDialog.show({
            message: '是否刪除????',
            buttons: [
                {
                    label: '確定',
                    cssClass: 'btn-success',
                    action: function(dialogRef) {
                            $('#closeform_'+id).submit();
                    }
                    
                },
                {
                    label: 'Close',
                    action: function(dialogRef) {
                        dialogRef.close();
                    }
                }


            ]
        });


    }
  


   
</script>


@endsection