@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>儲值功能</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">儲值功能</li>
    </ol>
</section>

  


  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('deposit/add')}}">新增</button>
        </div>
       
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

         
                <div class="box-body">
                   
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th class="rwd_hide">流水號</th>
                                    <th class="rwd_hide">儲值日期</th>
                                    <th>儲值金額</th>
                                    <th>儲值人</th>
                                    <th>刪除</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deposits as $key => $deposit)
                                <tr>
                                   
                                    <td class="rwd_hide">{{$deposit->no}}</td>
                                    <td class="rwd_hide">{{$deposit->date}}</td>
                                    <td>{{$deposit->qty}}</td>
                                    <td>{{$deposit->owner}}</td>
                                 
                                    <td>
                                        <form id='deleteform_{{$deposit->id}}' class="form-horizontal" action="{{url('deposit/delete/'.$deposit->id)}}" method="post">
                                            <input type="button" class="btn btn-danger btn-xs" value="X" onclick="dodelete({{$deposit->id}})"/>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   
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
<link rel="stylesheet" href="/dist/css/chosen.min.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script src="/dist/js/chosen.jquery.min.js"></script>
<script>

  
    $('#table').DataTable(
    {
        "order": [[ 2, "desc" ]],
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });
  



    function dodelete(id)
    {
        BootstrapDialog.show({
            message: '是否刪除????',
            buttons: [
                {
                    label: '確定',
                    cssClass: 'btn-success',
                    action: function(dialogRef) {
                            $('#deleteform_'+id).submit();
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