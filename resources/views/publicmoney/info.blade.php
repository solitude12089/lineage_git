@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>{{$moneylog->treasure->no}} 明細</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('publicmoney/index')}}">公積金</a></li>
      <li class="active">{{$moneylog->treasure->no}}</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{url('publicmoney/index')}}">返回</a>
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

         
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No</label>
                                    <input  class="form-control" readonly value="{{$moneylog->treasure->no}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Boss</label>
                                    <input  class="form-control" readonly value="{{$boss_list[$moneylog->treasure->boss_id]}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>物品名稱</label>
                                    <input  class="form-control" readonly value="{{$moneylog->treasure->item}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>持有人</label>
                                    <input  class="form-control" readonly value="{{$moneylog->treasure->owner_name->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>申請人</label>
                                    <input  class="form-control" readonly value="{{$moneylog->treasure->user->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>申請時間</label>
                                    <input  class="form-control" readonly value="{{$moneylog->treasure->created_at}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>參與團員</label>
                                    <textarea  class="form-control" readonly>
@foreach($moneylog->treasure->details as $k => $v)
@if($k==0){{$v->user->name}}@else,{{$v->user->name}}@endif
@endforeach
                                    </textarea>
                                   
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>實收金額</label>
                                    <input  class="form-control" readonly value="{{$moneylog->treasure->really_price}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    @if($customer->keyin_bonus==1)
                                    <label>分得鑽石(實收*0.9/{{count($moneylog->treasure->details)}} +1 KeyIn獎勵)
                                    </label>
                                    @else
                                    <label>分得鑽石(實收*0.9/{{count($moneylog->treasure->details)}})
                                    </label>
                                    @endif
                                    
                                    @if(0)
                                    <label>(06/18起的寶物,分得鑽石為實收/{{count($moneylog->treasure->details)}})</label>
                                    @endif
                                    <input  class="form-control" readonly value="{{$moneylog->amount}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>入帳時間</label>
                                    <input  class="form-control" readonly value="{{$moneylog->created_at}}">
                                </div>
                            </div>


                        </div>
                   

                       

                        <div class="col-md-6">
                            <label>圖片</label>
                            @if($moneylog->treasure->attachments)
                            <a href="{{url('files').'/'.$moneylog->treasure->attachments->disk_directory.'/'.$moneylog->treasure->attachments->disk_filename}}" data-lightbox="image" data-title="Image"> 
                                <img style="max-width: 100%;" src="{{url('files').'/'.$moneylog->treasure->attachments->disk_directory.'/'.$moneylog->treasure->attachments->disk_filename}}"></img>
                            </a>
                           
                            @endif
                        </div>

















                       
                    </div>
                      <!-- /.row -->
                </div>

          
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