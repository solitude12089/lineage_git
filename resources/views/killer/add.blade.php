@extends('layouts.modal')
@section('modal-title')
    新增出草申報
@stop
@section('modal-body')
    <style>
     
      @media screen and (max-width: 480px) {
        .modal-dialog{
          width: 100% !important;
          margin: 0px;
        }
        .ms-container{
          width: 100% !important;
        }
      
      }


    </style>
    <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
             
              <div class="box-body">

                <div class="form-group">
                  <label for="_date" class="col-sm-2 control-label">出草日期<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="input"  class="form-control" id="_date" name="_date"  data-date-format='yyyy-mm-dd' autocomplete="off">
                  </div>
                </div>
               

                <div class="form-group">
                  <label for="_qty" class="col-sm-2 control-label">擊殺+助攻數<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="_qty" name="_qty">
                  </div>
                </div>

                <div class="form-group">
                  <label for="_note" class="col-sm-2 control-label">備註</label>

                  <div class="col-sm-10">
                    <textarea class="form-control" id="_note" name="_note" rows="6" placeholder="備註 ..."></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="_note" class="col-sm-2 control-label">照片(按住Ctrl,可以選擇多張)<label style="color:red">*</label></label>


                  <div class="col-sm-10">
                    <input type="file" multiple class="form-control" id="_file" name="_file[]" accept="image/x-png,image/gif,image/jpeg"/>
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

  $( "#_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  function dopost () {
    if($('#_date').val().length==0)
    {
      alert('請輸入日期!!');
      return;
    }
    if($('#_qty').val().length==0)
    {
      alert('請輸入擊殺數!!');
      return;
    }
    if($('#_file').val().length==0)
    {
      alert('請上傳照片!!');
      return;
    }
    $('#dopost').prop('disabled', true);
    $('#addform').submit();
  }
 

</script>
@stop
