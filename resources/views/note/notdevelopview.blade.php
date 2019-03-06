@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>不可開發&無效審核</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">不可開發&無效審核</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary"  onclick="doclose()">歸檔結案</button>
            <button type="button" class="btn btn-primary"  onclick="doredo()">重新指派</button>  
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
                                  <th>客戶名稱</th>
                                  <th>電話</th>
                                  <th>備註</th>
                                  <th>指派業務</th>
                                  <th>業務評估結果</th>
                                 
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($notes as $key => $value)
                              <tr>
                                  <td style='text-align: center;'><input type="checkbox" name='note[{{$value->id}}][note_id]' value="{{$value->id}}"></td>
                                  <td><a href="{{url('note/note-detail-r-view').'/'.$value->id.'/'.'notdevelop'}}">{{$value->no}}</a></td>
                                  <td>{{$source_list[$value->source_id]}}</td>
                                  <td>{{$product_list[$value->product_id]}}</td>
                                  <td>{{$value->customer}}</td>
                                  <td>{{$value->tel}}</td>
                                  <td>
                                  @if(mb_strlen($value->note,'utf8')>6)
                                      <a onclick='show_note("{{$key}}")' style="cursor: pointer;">{!!mb_substr($value->note,0,6,'utf8')!!}...</a>
                                  @else
                                      {!!$value->note!!}
                                  @endif
                                  </td>
                                  <td>
                                    <select name='note[{{$value['id']}}][assigner]'>
                                      @foreach($user_list as $k => $v)
                                        @if($k == $value->assigner)
                                          <option selected value="{{$k}}">{{$v}}</option>
                                        @else
                                          <option value="{{$k}}">{{$v}}</option>
                                        @endif
                                      @endforeach
                                    </select>
                                  </td>
                                  <td>{{$status_list[$value->status]}}</td>
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

    var notes = <?php echo json_encode($notes); ?>;

    $('#table').DataTable(
    {
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });

    function show_note(str)
    {
        var s = notes[str].note;
        var html= '<pre>'+s+'</pre>';
        $('#modal-default .modal-body').empty().append(html);
        $('#modal-default').modal('show');

    }
    function doclose()
    {
      if($("#nextform input:checked").length == 0)
        return;
      BootstrapDialog.show({
            title: '警告',
            message: '確定要將勾選單據 歸檔結案 ??',
            buttons: [
                {
                    label: 'Yes',
                    cssClass: 'btn-danger',
                    action: function(dialogItself){
                        var url = "{{url('note/notdevelop-view/close')}}";
                        $('#nextform').attr('action',url);
                        $('#nextform').submit();
                    }
                }, 
                {
                    label: 'No',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        dialogItself.close();
                    }
                }
            ]
      });
    }

    function doredo()
    {
      if($("#nextform input:checked").length == 0)
        return;
      BootstrapDialog.show({
            title: '警告',
            message: '確定要將勾選單據 重新指派 ??',
            buttons: [
                {
                    label: 'Yes',
                    cssClass: 'btn-danger',
                    action: function(dialogItself){
                        var url = "{{url('note/notdevelop-view/redo')}}";
                        $('#nextform').attr('action',url);
                        $('#nextform').submit();
                    }
                }, 
                {
                    label: 'No',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        dialogItself.close();
                    }
                }
            ]
      });

    }

    
    

     // BootstrapDialog.show({
     //        message: 'Please select row.',
     //        buttons: [
     //            {
     //                label: 'Close',
     //                cssClass: 'btn-primary',
     //                action: function(dialogItself){
     //                    dialogItself.close();
     //                }
     //            }
     //        ]
     //    });
      
</script>


@endsection