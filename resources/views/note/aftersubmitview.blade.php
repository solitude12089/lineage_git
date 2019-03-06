@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>送件過後審查</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">送件過後審查</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary"  onclick="dosuccess()">過件歸檔</button>
            <button type="button" class="btn btn-primary"  onclick="donotdevelop()">不可開發歸檔</button>
            <button type="button" class="btn btn-primary"  onclick="doreject()">駁回</button> 
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
                                 
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($notes as $key => $value)
                              <tr>
                                  <td style='text-align: center;'><input type="checkbox" name='note[{{$value->id}}][note_id]' value="{{$value->id}}"></td>
                                  <td><a href="{{url('note/note-detail-r-view').'/'.$value->id.'/'.'aftersubmit'}}">{{$value->no}}</a></td>
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
                                  <td>{{$user_list[$value->assigner]}}</td>
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
    function dosuccess()
    {
      if($("#nextform input:checked").length == 0)
        return;
      BootstrapDialog.show({
            title: '警告',
            message: '確定要將勾選單據 過件歸檔 ??',
            buttons: [
                {
                    label: 'Yes',
                    cssClass: 'btn-danger',
                    action: function(dialogItself){
                        var url = "{{url('note/aftersubmit-view/success')}}";
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

    function doreject()
    {
      if($("#nextform input:checked").length == 0)
        return;
      BootstrapDialog.show({
            title: '警告',
            message: '確定要將勾選單據 駁回 ??',
            buttons: [
                {
                    label: 'Yes',
                    cssClass: 'btn-danger',
                    action: function(dialogItself){
                        var url = "{{url('note/aftersubmit-view/reject')}}";
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

    function donotdevelop()
    {
      if($("#nextform input:checked").length == 0)
        return;
      BootstrapDialog.show({
            title: '警告',
            message: '確定要將勾選單據 歸檔 ??',
            buttons: [
                {
                    label: 'Yes',
                    cssClass: 'btn-danger',
                    action: function(dialogItself){
                        var url = "{{url('note/aftersubmit-view/notdevelop')}}";
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