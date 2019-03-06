@extends('layouts.modal')
@section('modal-title')
    新增支出紀錄
@stop
@section('modal-body')
    <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
             
              <div class="box-body">

                
               

                <div class="form-group">
                  <label for="_reason" class="col-sm-2 control-label">事由<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input  class="form-control" id="_reason" name="_reason">
                  </div>
                </div>

                <div class="form-group">
                  <label for="_amount" class="col-sm-2 control-label">支出金額<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="_amount" name="_amount" min="0">
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
$('.chosen').chosen();

  function dopost () {
    if($('#_reason').val().length==0)
    {
      alert('請輸入"事由"!!');
      return;
    }
    if($('#_amount').val().length==0)
    {
      alert('請輸入"支出金額"!!');
      return;
    }
    $('#dopost').prop('disabled', true);
    $('#addform').submit();
  }
 

</script>
@stop
