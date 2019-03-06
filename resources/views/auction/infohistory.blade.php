@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>{{$auction->no}} 拍賣商品</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('auction/index')}}">拍賣場</a></li>
      <li class="active">{{$auction->no}}</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                
               <!--  <form id='addform' class="form-horizontal" action="{{url('auction/offer'.'/'.$auction->id)}}" method="post">
                    <input id="post_price" name="post_price" style="display:none"/>
                </form> -->
         

                <div class="box-body">
                    <div class="row">
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No</label>
                                    <input  class="form-control" readonly value="{{$auction->no}}">
                                </div>
                            </div>
                          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>物品名稱</label>
                                    <input  class="form-control" readonly value="{{$auction->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>最低競標價</label>
                                    <input  class="form-control" readonly value="{{$auction->min_price}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>數量</label>
                                    <input  class="form-control" readonly value="{{$auction->qty}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>得標價格</label>
                                    <input  class="form-control" readonly value="{{$auction->now_price}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>得標者</label>
                                    <input  class="form-control" readonly value="{{$auction->now_owner==null?'':$user_map[$auction->now_owner]}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>申請人</label>
                                    <input  class="form-control" readonly value="{{$user_map[$auction->user_id]}}">
                                </div>
                            </div>
                    </div>
                </div>
                @if(0)
                <div class="box-body">
                        <h2>出價明細</h2>
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>價格</th>
                                    <th>出價時間</th>
                                    <th>出價者</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auction->details as $key => $value)
                                <tr>
                                    <td>{{$value->price}}</td>
                                    <td>{{$value->updated_at}}</td>
                                    <td>{{$user_map[$value->user_id]}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                @endif
                

          
            </div>
        </div>

    </div>
    
</section>





@endsection
@section('script')
<link rel="stylesheet" href="/dist/css/lightbox.min.css">
<script src="/dist/js/lightbox.min.js"></script>

<script>




   
   
   
</script>


@endsection