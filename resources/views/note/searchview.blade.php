@extends('layouts.app')

@section('content')


<style>
option:disabled {
    background: #dddddd;
}
</style>


<section class="content-header">
    <h1>
      <small>查詢作業</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">查詢作業</li>
    </ol>
</section>

  
<section class="content">
   <div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">查詢作業</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">
        <form id='nextform' class="form-horizontal" action="{{url('note/search-view')}}" method="post">
          <div class="col-md-4" style='float:right'>
              <select id="add_filter" onchange="handleSelect(this)" class="form-control" style="float:left;width:70%">
                  <option></option>
                  @foreach($codes as $code)
                    <option value="{{$code->COLUMN_NAME}}">{{$code->COLUMN_COMMENT}}</option>
                  @endforeach
              </select>
              <button type="button" style='float:right' class="btn btn-bitbucket" onclick="dopost()">Search</button>
          </div>
       
          <div class="col-md-8">
            @foreach($codes as $code)
              <div id="div-{{$code->COLUMN_NAME}}" class="col-md-12" style="display:none">
                <div class="col-sm-3">
                  <input type="checkbox" class='control-label' style="float:left;margin-top: 5px;" onchange="div_checkbox(this)"/>
                  <label for="packages">{{$code->COLUMN_COMMENT}}</label>
                </div>
                <div class="col-sm-2">
                    @if($code->COLUMN_NAME=="created_at")
                      <select  name="filter[{{$code->COLUMN_NAME}}][0]" class="ms-choice">
                        <option value='between' selected>between</option>
                      </select>
                    @else
                      <select  name="filter[{{$code->COLUMN_NAME}}][0]" class="ms-choice">
                        <option value='is' selected>is</option>
                        <option value='like'>like</option>
                      </select>
                    @endif
                    
                </div>
                @if($code->COLUMN_NAME=="created_at"||$code->COLUMN_NAME=="sign_status"||$code->COLUMN_NAME=="product_id"||$code->COLUMN_NAME=="assigner"||$code->COLUMN_NAME=="status"||$code->COLUMN_NAME=="source_id")
                  @if($code->COLUMN_NAME=="product_id")
                  <div class="col-sm-7">
                      <select name="filter[{{$code->COLUMN_NAME}}][1]">
                        @foreach($product_list as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                      </select>
                  </div>
                  @endif
                  @if($code->COLUMN_NAME=="assigner")
                  <div class="col-sm-7">
                      <select name="filter[{{$code->COLUMN_NAME}}][1]">
                        @foreach($user_list as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                      </select>
                  </div>
                  @endif
                  @if($code->COLUMN_NAME=="status")
                  <div class="col-sm-7">
                      <select name="filter[{{$code->COLUMN_NAME}}][1]">
                        @foreach($status_list as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                      </select>
                  </div>
                  @endif
                  @if($code->COLUMN_NAME=="sign_status")
                  <div class="col-sm-7">
                      <select name="filter[{{$code->COLUMN_NAME}}][1]">
                        @foreach($sign_status_list as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                      </select>
                  </div>
                  @endif
                  @if($code->COLUMN_NAME=="source_id")
                  <div class="col-sm-7">
                      <select name="filter[{{$code->COLUMN_NAME}}][1]">
                        @foreach($source_list as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                      </select>
                  </div>
                  @endif
                  @if($code->COLUMN_NAME=="created_at")
                  <div class="col-sm-7">
                      <input name="filter[{{$code->COLUMN_NAME}}][1]" type="date">
                      ~
                      <input name="filter[{{$code->COLUMN_NAME}}][2]" type="date">
                  </div>
                  @endif
                  
                @else
                  <div class="col-sm-7">
                      <input name="filter[{{$code->COLUMN_NAME}}][1]" />
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </form> 
    </div>
    <!-- /.row -->
  </div>
  <!-- /.box-body -->

  <div class="box-footer">
    <div  id="div_table" class="col-lg-12">
    </div>
  </div>
</div>

    
</section>




<div class="modal fade" id="modal-default" >
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
  var dt;
  var qt;
  var box_numb = 1;
  var table = null;
  var user_list = <?php echo json_encode($user_list); ?>;
  var source_list = <?php echo json_encode($source_list); ?>;
  var product_list = <?php echo json_encode($product_list); ?>;
  var status_list = <?php echo json_encode($status_list); ?>;
  var sign_status_list = <?php echo json_encode($sign_status_list); ?>;
  $('.col-md-12').find('select:eq(1)').val('');
  function clear_con()
  {
    $.each(filter_codes, function(index) {
      if(filter_codes[index].col_type =='M' || filter_codes[index].col_type=='S')
      {
        $('#'+filter_codes[index].field).multipleSelect("uncheckAll");
      }
    });
  }
 
  function filter_show(obj){
    var text = $(obj).text();
    $(obj).text(text=="Hide" ? "Show" : "Hide");
    $("#filter_body").toggle( "slow" );
  }



  function handleSelect(obj)
  {
    var selectedOption = obj.selectedIndex;
    if(selectedOption=="0")return;
    $("#add_filter option:eq("+selectedOption+")").attr("disabled","disabled");
    var select_div =  $('#div-'+obj.selectedOptions[0].value);
    select_div.find('input:checkbox').click();
  }

  function div_checkbox(obj)
  {
    if(obj.checked) {
      $(obj).closest('.col-md-12').css('display','');
    }
    else
    {
      var select_id = $(obj).closest('.col-md-12').attr('id').split('-')[1];
      $(obj).closest('.col-md-12').css('display','none');
      var t =  $(obj).closest('.col-md-12').find('input:eq(1)');
      if(t.length==0)
      {
        $(obj).closest('.col-md-12').find('select:eq(1)').val('');
      }
      else
      {
        t.val('');
        var t2 =  $(obj).closest('.col-md-12').find('input:eq(2)');
        if(t2.length!=0)
        {
          t2.val('');
        }
      }
      $('select option[value="'+select_id+'"]').removeAttr('disabled');
    }
    
  }

  function show_note(str)
  {
      
      var html= '<pre>'+str+'</pre>';
      $('#modal-default .modal-body').empty().append(html);
      $('#modal-default').modal('show');

  }


  function dopost()
  {
    var form = $('#nextform');
    var url = form.attr('action');
    var postdata = form.serialize();
    $.ajax({
        type: 'Post',
        data: postdata,
        url: url
      }).done(function(result){
        $('#div_table').empty();
        if(table!=null)
        {
          table = null;
        }
        if(result!=null)
        {
          var html = "<table id='rt_tb' class='table table-bordered table-hover'>"+
                      "<thead>"+
                        "<tr>"+
                            "<th>No</th>"+
                            "<th>來源</th>"+
                            "<th>產品別</th>"+
                            "<th>類別</th>"+
                            "<th>客戶名稱</th>"+
                            "<th>電話</th>"+
                            "<th>指派業務</th>"+
                            "<th>備註</th>"+
                            "<th>流程狀態</th>"+
                            "<th>單據狀態</th>"+
                       "</tr>"+
                    "</thead>"+
                    "<tbody>";
          $.each(result,function(key,value){
            html=html+"<tr>"+
                  "<td><a href='{{url('note/note-detail-r-view')}}"+"/"+value.id+"/search'>"+value.no+"</a></td>"+
                  "<td>"+source_list[value.source_id]+"</td>"+
                  "<td>"+product_list[value.product_id]+"</td>"+
                  "<td>"+value.type+"</td>"+
                  "<td>"+value.customer+"</td>"+
                  "<td>"+value.tel+"</td>"+
                  "<td>"+user_list[value.assigner]+"</td>";

            if(value.note.length>6)
            {
               html=html+"<td><a onclick='show_note(\""+value.note+"\")' style='cursor: pointer;'>"+value.note.substring(0, 6)+"...</a></td>";
            }
            else
            {
              html = html + "<td>"+value.note+"</td>";
            }                    
            html=html+"<td>"+status_list[value.status]+"</td>"+
                  "<td>"+sign_status_list[value.sign_status]+"</td>"+
                  "</tr>";
          });
          html = html + "</tbodt></table>";
          $('#div_table').append(html);

          table = $('#rt_tb').dataTable(); 
        }

      });
  }


  
   
      
</script>


@endsection