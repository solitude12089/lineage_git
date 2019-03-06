@extends('layouts.app')

@section('content')

<style>
     
      @media screen and (max-width: 480px) {
        .rwd_hide{
            display: none !important;
        }
      
      }


</style>


<section class="content-header">
    <h1>
      <small>拍賣場</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">拍賣場</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @if(strpos(Auth::user()->role_id, '3') !== false)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('auction/add')}}">新增拍賣品</button>
            @endif
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                            <li class="">
                              <a aria-expanded="false" data-toggle="tab" href="#history-list">截標商品</a>
                            </li>
                            <li class="active">
                              <a aria-expanded="true" data-toggle="tab" href="#export-list">競標中</a>
                            </li>
                            
                            <li class="pull-left header"><i class="fa fa-inbox"></i>拍賣清單</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="tab-pane active" id="export-list">
                            <div class="box-body">
                                <table id="table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            
                                            <th>No</th>
                                            <th>寶物名稱</th>
                                            <th>最低競標價</th>
                                            <th>數量</th>
                                            @if(0)
                                            <th>目前價格</th>
                                            <th>目前得標者</th>
                                             @endif
                                            <th>申請人</th>
                                            <th>截標時間</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auction_list as $key => $value)
                                        <tr>
                                            <td><a href="{{url('auction/info').'/'.$value->id}}">{{$value->no}}</a></td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->min_price}}</td>
                                            <td>{{$value->qty}}</td>
                                            @if(0)
                                            <td>{{$value->now_price}}</td>
                                            <td>{{$value->now_owner==null?'':$user_map[$value->now_owner]}}</td>
                                            @endif
                                            <td>{{$user_map[$value->user_id]}}</td>
                                            <td>{{$value->end_day}} 23:59:59</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="history-list">
                            <div class="box-body">
                                <table id="history_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            
                                            <th>No</th>
                                            <th>寶物名稱</th>
                                            <th>最低競標價</th>
                                            <th>數量</th>
                                            <th>得標價格</th>
                                            <th>得標者</th>
                                            <th>申請人</th>
                                            <th>截標時間</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($history_auction as $key => $value)
                                        <tr>
                                            <td><a href="{{url('auction/infohistory').'/'.$value->id}}">{{$value->no}}</a></td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->min_price}}</td>
                                            <td>{{$value->qty}}</td>
                                            <td>{{$value->now_price}}</td>
                                            <td>{{$value->now_owner==null?'':$user_map[$value->now_owner]}}</td>
                                            <td>{{$user_map[$value->user_id]}}</td>
                                            <td>{{$value->end_day}} 23:59:59</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                           
                                       
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>

    </div>

    
</section>



@endsection
@section('script')




<link rel="stylesheet" href="/dist/css/chosen.min.css">
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.quicksearch.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script src="/dist/js/chosen.jquery.min.js"></script>
<script>

</script>


@endsection