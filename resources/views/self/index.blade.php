@extends('layouts.app')

@section('content')


<style>
.my-box{
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #dd4b39;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);

}

</style>


<section class="content-header">
    <h1>
      <small>個人銀行</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">個人銀行</li>
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
                    <div class="col-md-8">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>入帳單據</th>
                                    <th>金額</th>
                                    <th>入帳時間</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moneylogs as $key => $value)
                                <tr>
                                    @if($value->source_type=="treasure")
                                        <td><a href="{{url('self/info').'/'.$value->id}}">{{$value->treasure->no}}</a></td>
                                    @else
                                        <td>{{$value->source_type}}</td>
                                    @endif
                                   
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->created_at}}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 my-box box-danger">
                        <div class="form-group">
                            <label for="_note" class="col-sm-6 control-label" style="font-size: 30px; margin:45px auto;">可用餘額</label>
                            <div class="col-sm-10" style="margin: 20px 30px;font-size: 26px;">
                            {{$moneylogs->sum('amount')}}
                            </div>
                            <button style="margin: 40px auto;float:right;" class="btn btn-group-justified btn-success" onclick="doexport()">領錢</button>
                        </div>
                    </div>
                </div>


                <form id='addform' class="form-horizontal" action="{{url('export/doexport')}}" method="post">
                    <input id="amount" name="amount" style="display:none"/>
                </form>

          
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
        <h4 class="modal-title">備註..</h4>
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

    function doexport(){
        BootstrapDialog.show({
            message: '請輸入提領金額 <input type="number" class="form-control">',
            buttons: [
                {
                    label: '確定',
                    cssClass: 'btn-success',
                    action: function(dialogRef) {
                        var money = dialogRef.getModalBody().find('input').val();
                        if(money.length==0)
                        {
                            alert('請輸入提領金額!!!');
                            dialogRef.close();
                            return;
                        }
                        if(money<0)
                        {
                            alert('不可小於0!!!');
                            dialogRef.close();
                            return;
                        }
                        else
                        {

                            $(this).prop('disabled', true);
                            $('#amount').val(money);
                            $('#addform').submit();

                        }

                        
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