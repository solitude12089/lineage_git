@extends('layouts.modal')
@section('modal-title')
    新增儲值
@stop
@section('modal-body')
    <style>
      .ms-optgroup-label{
        color:red !important;
      }

    @media screen and (max-width: 480px) {
      .modal-dialog{
        width: 100% !important;
        margin: 0px;
      }
      .ms-container{
        width: 100% !important;
      }
      .more-file{
        position: inherit !important;
        float:inherit !important;
        margin-left: 0px !important;
      }

    }


    </style>
   
    <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
             
      <div class="box-body">
                <div class="form-group">
                 
                </div>

              


               

                <div class="form-group">
                  <label for="_owner" class="col-sm-2 control-label">用戶<label style="color:red">*</label></label>
                  <div class="col-sm-10">
                     <select  class="form-control chosen" name="_owner">
                          @foreach($user_list as $key => $value)
                              <option value='{{$value->email}}'>{{$value->name}}</option>
                          @endforeach
                    </select>
                  </div> 

                </div>

                <div class="form-group">
                  <label for="_qty" class="col-sm-2 control-label">金額<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="_qty" name="_qty">
                  </div>
                </div>

      </div>
    </form>

@stop
@section('modal-footer')
    <button id="dopost" type="button" class="btn btn-primary" onclick="dopost()">存檔</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">取消</button>

@stop


@section('modal-script')

<script>
  var user_list =  <?php echo json_encode($user_list); ?>;
 


  function dopost () {
   


    if($('#_qty').val().length==0)
    {
      alert('請輸入金額!!');
      return;
    }
   
    $('#dopost').prop('disabled', true);
    $('#addform').submit();
  }

 
  
$('.chosen').chosen();
</script>
@stop
