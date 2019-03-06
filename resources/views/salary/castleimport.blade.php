@extends('layouts.modal')
@section('modal-title')
    城鑽匯入  -  <label style="color:red;">{{$start_day}}</label>
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
                  <label for="_qty" class="col-sm-2 control-label">總鑽收<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="_qty" name="_qty"  min="0">
                  </div>
                </div>

                <div class="form-group">
                  <label for="_mercenary" class="col-sm-2 control-label">傭兵數<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="_mercenary" name="_mercenary"  min="0" value=0>
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
    $('#dopost').prop('disabled', true);
    $('#addform').submit();
  }
 

</script>
@stop
