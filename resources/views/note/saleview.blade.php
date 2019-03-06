@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>業務作業</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> 業務作業</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary"  onclick="donext()">送出</button>  
            <button type="button" class="btn btn-success btn-xs" value="Y" onclick="c_tag(this)">#Y</button>
            <button type="button" class="btn btn-success btn-xs" value="A" onclick="c_tag(this)">#A</button>
            <button type="button" class="btn btn-success btn-xs" value="B" onclick="c_tag(this)">#B</button>
            <button type="button" class="btn btn-success btn-xs" value="C" onclick="c_tag(this)">#C</button>
            <button type="button" class="btn btn-bitbucket btn-xs" value="All" onclick="c_tag(this)">#All</button>
           
        </div>
       
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form id='nextform' class="form-horizontal" action="{{url('note/sale-view')}}" method="post">
                      <table id="table" class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th style='text-align: center;'><input type="checkbox" onclick="click_all(this)"></th>
                                  <th>No</th>
                                  <th>來源</th>
                                  <th>產品別</th>
                                  <th>h_type</th>
                                  <th>類別</th>
                                  <th>客戶名稱</th>
                                  <th>電話</th>
                                  <th>指派業務</th>
                                  <th>備註</th>
                                  <th>評估結果</th>
                                 
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($notes as $key => $value)
                              <tr>
                                  <td style='text-align: center;'><input type="checkbox" name='note[{{$value->id}}][note_id]' value="{{$value->id}}"></td>
                                  <td><a href="{{url('note/note-detail-view').'/'.$value->id.'/sale'}}">{{$value->no}}</a></td>
                                  <td>{{$source_list[$value->source_id]}}</td>
                                  <td>{{$product_list[$value->product_id]}}</td>
                                  <td>{{$value->type}}</td>
                                  <td>
                                    <select onchange="change_type(this)">
                                      <option  {{$value->type=='Y'?'selected="selected"':''}} value="Y">Y</option>
                                      <option  {{$value->type=='A'?'selected="selected"':''}} value="A">A</option>
                                      <option  {{$value->type=='B'?'selected="selected"':''}} value="B">B</option>
                                      <option  {{$value->type=='C'?'selected="selected"':''}} value="C">C</option>
                                    </select>
                                  </td>


                                  <td>{{$value->customer}}</td>
                                  <td>{{$value->tel}}</td>
                                  <td>{{$user_list[$value->assigner]}}</td>
                                  <td>
                                  @if(mb_strlen($value->note,'utf8')>6)
                                      <a onclick='show_note("{{$key}}")' style="cursor: pointer;">{!!mb_substr($value->note,0,6,'utf8')!!}...</a>
                                  @else
                                      {!!$value->note!!}
                                  @endif
                                  </td>
                                  <td>
                                    <select name='note[{{$value->id}}][assess]'>
                                      <option></option>
                                      <option value="送件">送件</option>
                                      <option value="不可開發">不可開發</option>
                                      <option value="無效">無效</option>
                                    </select>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                    </form>
                </div>
          
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
    var now_tag = "All";
    var notes = <?php echo json_encode($notes); ?>;
    var table = $('#table').dataTable(
    {
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "columnDefs": [
      {
          "targets": [ 4 ],
          "visible": false,
          "searchable": true
      }],
    });
   

    function c_tag(v)
    {
      $('form input[type="checkbox"]').prop('checked', false);

      $('.btn-bitbucket').removeClass('btn-bitbucket').addClass('btn-success')
      $(v).removeClass('btn-success').addClass('btn-bitbucket')


      now_tag=$(v).val();
      table.fnDraw();
    }

    function show_note(str)
    {
        var s = notes[str].note;
        var html= '<pre>'+s+'</pre>';
        $('#modal-default .modal-body').empty().append(html);
        $('#modal-default').modal('show');

    }
    function donext()
    {
      var error = 0;
      $.each($("#nextform input:checked"),function(k,v){
        if($(v).closest('th').length!=0)
          return true;
        if($(v).closest('tr').find('td:eq(3)').text().length==0 && error==0)
        {
          BootstrapDialog.show({
            title: '警告',
            message: '請選擇 產品別',
            buttons: [
                {
                    label: 'No',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        dialogItself.close();
                    }
                }
            ]
          });
          error = 1 ;
          return;
        }
        if($(v).closest('tr').find('select:eq(1)').val().length==0 && error==0)
        {
          BootstrapDialog.show({
            title: '警告',
            message: '請選擇 評估結果',
            buttons: [
                {
                    label: 'No',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        dialogItself.close();
                    }
                }
            ]
          });
          error = 1 ;
          return;
        }
      })

      if(error == 0)
        $('#nextform').submit();
    }

    function change_type(obj)
    {
      var url = "{{url('note/chang-type')}}";
      var _id = $(obj).closest('tr').find('input').val();
      var _type = $(obj).val();
      var postdata = {
        'id':_id,
        'type':_type
      }
      $.ajax({
        type: 'Post',
        data: postdata,
        url: url});
    }

    $.fn.dataTableExt.afnFiltering.push(
       function( oSettings, aData, iDataIndex ) {

          //filter on current position which is column 3 (zero-based index is 2)
          colFilterID = 4;

          //get our filter element
          filterElement = aData[colFilterID];
       
          //get our filter time from the SELECT drop down in header of column
         
          if(now_tag == 'All') {
             return true;
          }

          if(now_tag == filterElement ) {
             return true;
          } else {
             return false;    
          }
    });



  
   
      
</script>


@endsection