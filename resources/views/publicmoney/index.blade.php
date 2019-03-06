@extends('layouts.app')

@section('content')


<style>
.my-box{
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #dd4b39;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);

}

</style>


<section class="content-header">
    <h1>
      <small>公積金</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">公積金</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('publicmoney/add')}}">新增支出</button>
        </div>
       
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="box">

              

         
                <div class="box-body">
                    <div class="col-md-12">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>入帳單據</th>
                                    <th>金額</th>
                                    <th>入帳時間</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($public_moneylogs as $key => $value)
                                <tr>
                                    @if($value->source_type=="treasure")
                                        <td><a href="{{url('publicmoney/info').'/'.$value->id}}">{{$value->treasure->no}}</a></td>
                                    @else
                                        <td>{{$value->source_type}}</td>
                                    @endif
                                   
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->created_at}}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                   
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
      "order": [[ 2, "desc" ]],
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });


   
   
</script>


@endsection