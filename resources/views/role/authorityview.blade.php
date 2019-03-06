@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>權限設定</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">權限設定</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                      <table id="table" class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th style="display:none">ID</th>
                                  <th>Name</th>
                                  <th>角色</th>
                                  <th>狀態</th>
                                  <th>密碼重置</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($user_list as $key => $value)
                              <tr>
                                  <td style="display:none"><input value="{{$value->id}}"/></td>
                                  <td>{{$value->name}}</td>
                                  <td>
                                    @if(strpos(Auth::user()->role_id, '5') !== false)
                                      <select class="form-control chosen" multiple onchange="change_authority(this)">
                                        @foreach($role_list as $k => $v)
                                          @if(strpos($value->role_id,(string)$k)!== false)
                                            <option selected value="{{$k}}">{{$v}}</option>
                                          @else
                                            <option value="{{$k}}">{{$v}}</option>
                                          @endif
                                        @endforeach
                                      </select>
                                    @else
                                      
                                    @endif
                                  </td>
                                  <td>

                                    <select class="form-control"  onchange="change_status(this)"  {{$value->status =='9'?"style=color:red;":''}}>
                                      <option {{$value->status =='1'?"selected":""}} value="1">正常</option>
                                      <option {{$value->status =='9'?"selected":""}} value="9">停用</option>
                                    </select>
                                  </td>
                                  <td>
                                     <button class="btn btn-success" onclick="resetpwd(this)" >重置</button>
                                  </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                   
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
<link rel="stylesheet" href="/dist/css/chosen.min.css">
<script src="/dist/js/chosen.jquery.min.js"></script>
<script>
  $('.chosen').chosen({
    width: "95%",
    single_backstroke_delete :true
  });
  function change_authority(obj)
  {
    var url = "{{url('role/change-authority')}}";
    var _id = $(obj).closest('tr').find('input').val();
    var _authority = $(obj).val();
  
    var postdata = {
      'id':_id,
      'authority':_authority
    }
    $.ajax({
      type: 'Post',
      data: postdata,
      url: url
    });
  }

  function change_status(obj)
  {
    var url = "{{url('role/change-status')}}";
    var _id = $(obj).closest('tr').find('input').val();
    var _status = $(obj).val();
  
    var postdata = {
      'id':_id,
      'status':_status
    }
    $.ajax({
      type: 'Post',
      data: postdata,
      url: url
    });
  }
  function resetpwd(obj){
    var url = "{{url('role/resetpwd')}}";
    var _id = $(obj).closest('tr').find('input').val();
    var postdata = {
      'id':_id
    }
    $.ajax({
      type: 'Post',
      data: postdata,
      url: url
    }).done(function( data ) {
      alert( "重置完成" );
    });
  }
   
      
</script>


@endsection