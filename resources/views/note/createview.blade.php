@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>建檔作業</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">建檔作業</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('note/create-add')}}">新增</button>
            <button type="button" class="btn btn-primary" onclick="donext()">送出</button>  
        </div>
       
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

         
                <div class="box-body">
                    <form id='nextform' class="form-horizontal" action="{{url('note/create-view')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>來源</th>
                                    <th>客戶名稱</th>
                                    <th>電話</th>
                                    <th>指派業務</th>
                                    <th>備註</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notes as $key => $value)
                                <tr>
                                    <td style='text-align: center;'><input type="checkbox" name='next[]' value="{{$value->id}}"></td>
                                    <td>{{$value->no}}</td>
                                    <td>{{$source_list[$value->source_id]}}</td>
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
    function donext()
    {
        $('#nextform').submit();
    }
</script>


@endsection