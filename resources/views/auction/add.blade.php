@extends('layouts.modal')
@section('modal-title')
    新增拍賣品
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
                  <div class="col-sm-12">
                    <label class="col-sm-2 control-label">寶物名稱<label style="color:red">*</label></label>
                    <div class="col-sm-8">
                      <input class="form-control" id="name" name="name" placeholder="寶物名稱..." required="required"/>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-12">
                    <label class="col-sm-2 control-label">最低競標價<label style="color:red">*</label></label>
                    <div class="col-sm-8">
                      <input class="form-control" type="number" id="min_price" name="min_price" placeholder="最低競標價..." required="required"/>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div id="item_row" class="col-sm-12">
                    <label class="col-sm-2 control-label">數量<label style="color:red">*</label></label>
                    <div class="col-sm-8">
                      <input class="form-control" type="number" id="qty" name="qty" placeholder="數量..." required="required"/>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div id="item_row" class="col-sm-12">
                    <label class="col-sm-2 control-label">截標日期<br>(23:59:59)<label style="color:red">*</label></label>
                    <div class="col-sm-8">
                      <input class="form-control" type="date" id="end_day" name="end_day"  required="required"/>
                    </div>
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
  function dopost () {
    if($('#name').val().length==0)
    {
      alert('請輸入商品名稱!!');
      return;
    }
    if($('#min_price').val().length==0)
    {
      alert('請輸入最低競價!!');
      return;
    }
    if($('#qty').val().length==0)
    {
      alert('請輸入數量!!');
      return;
    }
    if($('#end_day').val()=="")
    {
      alert('請輸入截標日期!!');
      return;
    }
    $('#dopost').prop('disabled', true);
    $('#addform').submit();
  }
 
</script>
@stop
