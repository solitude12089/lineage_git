@extends('layouts.modal')
@section('modal-title')
    新增領取紀錄
@stop
@section('modal-body')
    <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
             
              <div class="box-body">

                <div class="form-group">
                  <label for="_date" class="col-sm-2 control-label">領取人<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <select id="_user_id" class="form-control chosen"  name="_user_id">
                      @foreach($user_list as $key => $value)
                      <option>{{$value->email}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
               

                <div class="form-group">
                  <label for="_source_type" class="col-sm-2 control-label">領取寶物<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input  class="form-control" id="_source_type" name="_source_type">
                  </div>
                </div>

                <div class="form-group">
                  <label for="_amount" class="col-sm-2 control-label">扣分<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="_amount" name="_amount">
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
    if($('#_user_id').val().length==0)
    {
      alert('請輸入"領取人"!!');
      return;
    }
    if($('#_source_type').val().length==0)
    {
      alert('請輸入"領取寶物"!!');
      return;
    }
    if($('#_amount').val().length==0)
    {
      alert('請輸入"扣分"!!');
      return;
    }
    $('#dopost').prop('disabled', true);
    $('#addform').submit();
  }
 

</script>
@stop
