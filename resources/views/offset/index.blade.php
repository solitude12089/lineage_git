@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>扣薪入帳審核</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">扣薪入帳審核</li>
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
              

         
                <div class="box-body">
                  
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>流水號</th>
                                    <th>入帳單據</th>
                                    <th>入帳金額</th>
                                    <th>申請人</th>
                                    <th>申請時間</th>
                                    <th>照片</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offsets as $key => $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td><a href="{{url('treasure/info/'.$value->treasure_id)}}">{{$value->treasure_displayname}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->user_id}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td style="text-align:center;">
                                        <a  data-toggle="modal" data-target="#ajax-modal" href="{{url('offset/pic').'/'.$value->id}}"><i class="fa fa-eye"></i></a>
                                    </td>
                                     
                                    <td>
                                        <form id='nextform_{{$value->id}}' class="form-horizontal" action="{{url('offset/doconfirm'.'/'.$value->id)}}" method="post">
                                            <input type="button" class="btn btn-success btn-xs" value="確認完成" onclick="doconfirm({{$value->id}})"/>
                                        </form>
                                    </td>
                                    <td>
                                        <form id='closeform_{{$value->id}}' class="form-horizontal" action="{{url('offset/doclose'.'/'.$value->id)}}" method="post">
                                            <input type="button" class="btn btn-danger btn-xs" value="刪除" onclick="doclose({{$value->id}})"/>
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



    function doconfirm(id)
    {
        BootstrapDialog.show({
            message: '是否確資料無誤??????',
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