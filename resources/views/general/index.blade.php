@extends('layouts.app')

@section('content')




<section class="content-header">
    <h1>
      <small>金庫總覽 <label style="color:red">Sum : {{$sum}}</label></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">金庫總覽</li>

    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            
        </div>
       
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>存款</th>
                                <th>明細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $value)
                            <tr>
                                <td>{{$value->name}}</td>
                                @if($value->moneylogs)
                                    <td>{{$value->moneylogs->sum('amount')}}</td>
                                    <td><a href="{{url('general/info'.'/'.$value->id)}}">明細</td>
                                @else
                                    <td>0</td>
                                @endif
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
<script>


    $('#table').DataTable(
    {
        'iDisplayLength':50,
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });
  
   
   
</script>


@endsection