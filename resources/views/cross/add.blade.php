@extends('layouts.modal')
@section('modal-title')
    A新增寶物申報
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
                  <label for="_qty" class="col-sm-2 control-label">Boss</label>

                  <div class="col-sm-10">
                    <select  class="form-control chosen" name="_boss_id" required="required">
                        @foreach($boss_list as $key => $value)
                            <option value='{{$key}}'>{{$value}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <div id="item_row" class="col-sm-12">
                    <label for="_day" class="col-sm-2 control-label">日期<label style="color:red">*</label></label>
                    <div class="col-sm-4">
                      <input class="form-control"  type="input" id="_day" name="_day" placeholder="Date" required="required" autocomplete="off" />
                    </div>

                    <label for="_qty" class="control-label" style="float:left">時間<label style="color:red">*</label></label>
                    <div class="col-sm-4">
                      <input class="form-control"  type="input" id="_time" name="_time" placeholder="Time" required="required" autocomplete="off" />
                    </div>

                  </div>

                </div>


                <div id="item_div" class="form-group">
                  <div id="item_row" class="col-sm-12">
                    <label for="_note" class="col-sm-2 control-label">寶物名稱<label style="color:red">*</label></label>
                    <div class="col-sm-4">
                      <input class="form-control" name="_item[]" placeholder="寶物名稱..." required="required"/>
                    </div>


                    <label for="_qty" class="control-label" style="float:left">持有人</label>
                    <div class="col-sm-4">
                      <select  class="form-control chosen" name="_owner[]">
                          @foreach($user_list as $key => $value)
                              <option value='{{$value->email}}'>{{$value->customer->username}}_{{$value->name}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <input type="button" class="btn btn-yahoo more-file" value="+" onclick="moreitem()" style="position: absolute;float: right;margin-left: -60px;"/>
                </div>


               


                <div class="form-group">
                  <label for="_members" class="col-sm-2 control-label">參與人員<label style="color:red">*</label>   <br><label style="color:red">PS.持有人也要選到喔!</label></br></label>


                  <div class="col-sm-10">
                    <select id='_members' multiple='multiple' name="_members[]">
                      @foreach($bygroup as $key => $guild)
                        <optgroup label='{{$key}}'>
                        @foreach($guild as $k => $value)
                          <option value="{{$value->email}}">{{$key}}_{{$value->name}}</optin>
                        @endforeach
                        </optgroup>
                      @endforeach
  
                    </select>
                  </div>
                </div>


                <div class="form-group">
                  <label for="_note" class="col-sm-2 control-label">照片<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="file"  class="form-control" id="_file" name="_file[]" accept="image/x-png,image/gif,image/jpeg"/>
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
  $( "#_day" ).datepicker({ 
    dateFormat: 'yy-mm-dd', 
    timeFormat: "HH:mm"
  });

  $( "#_time" ).timepicker({ 
    timeFormat: "HH:mm"
  });



  function dopost () {
    if($('#_day').val().length==0)
    {
      alert('請輸入日期!');
      return;
    }

    if($('#_time').val().length==0)
    {
      alert('請輸入時間!!');
      return;
    }
    // if($('[name="_item[]"').val().length==0)
    // {
    //   alert('請輸入寶物名稱!!');
    //   return;
    // }

    if($('#_members').val().length==0)
    {
      alert('請選擇參與人員!!');
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

  function moreitem(){
    var h = '<div class="col-sm-12">\
              <label for="_note" class="col-sm-2 control-label">寶物名稱<label style="color:red">*</label></label>\
                    <div class="col-sm-4">\
                      <input class="form-control" name="_item[]" placeholder="寶物名稱..." required="required"/>\
                    </div>\
                    <label for="_qty" class="control-label" style="float:left">持有人</label>\
                    <div class="col-sm-4">\
                      <select  class="form-control chosen" name="_owner[]">';
    $.each(user_list,function(k,v){
      h=h+'<option value="'+v.email+'">'+v.name+'</option>';
    })
    h=h+'</select>\
                    </div>\
                  </div>';
    $('#item_div').append(h);
    $('.chosen').chosen();
  }
   
  $('#_members').multiSelect({
    selectableHeader: "<input type='text' style='width: 167px;' class='search-input' autocomplete='off' placeholder='請輸入收尋文字'>",
    selectionHeader: "<input type='text' style='width: 167px;'  class='search-input' autocomplete='off' placeholder='請輸入收尋文字'>",
    afterInit: function(ms){
      var that = this,
          $selectableSearch = that.$selectableUl.prev(),
          $selectionSearch = that.$selectionUl.prev(),
          selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
          selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

      that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
      .on('keydown', function(e){
        if (e.which === 40){
          that.$selectableUl.focus();
          return false;
        }
      });

      that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
      .on('keydown', function(e){
        if (e.which == 40){
          that.$selectionUl.focus();
          return false;
        }
      });
    },
    afterSelect: function(){
      this.qs1.cache();
      this.qs2.cache();
    },
    afterDeselect: function(){
      this.qs1.cache();
      this.qs2.cache();
    }
  });
$('.chosen').chosen();
</script>
@stop
