@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>{{$treasure->no}} 明細</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('cross/index')}}">跨服寶物申報</a></li>
      <li class="active">{{$treasure->no}}</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{url('cross/index')}}">返回</a>
          
            @if(date('Y-m-d H:i:s',strtotime($treasure->created_at . '+1 days'))>$now)
                @if(!$treasure->is_join)
                <a class="btn btn-success" href="{{url('cross/join').'/'.$treasure->id}}">申請補登</a>
                @endif
                @if($treasure->is_complement)
                <a class="btn btn-danger" href="{{url('cross/unjoin').'/'.$treasure->id}}">取消補登</a>
                @endif
            @endif
            @if(strpos(Auth::user()->role_id, '6') !== false)
                <a class="btn btn-info" href="{{url('cross/edit').'/'.$treasure->id}}">編輯</a>
                <a class="btn btn-danger" href="{{url('cross/delete').'/'.$treasure->id}}">刪除單據</a>
            @endif
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
                                    <input  class="form-control" readonly value="{{$treasure->no}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Boss</label>
                                    <input  class="form-control" readonly value="{{$boss_list[$treasure->boss_id]}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>日期時間</label>
                                    <input  class="form-control" readonly value="{{$treasure->day}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>物品名稱</label>
                                    <input  class="form-control" readonly value="{{$treasure->item}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>持有人</label>
                                    <input  class="form-control" readonly value="{{$treasure->owner_name->customer->username.'_'.$treasure->owner_name->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>申請人</label>
                                    <input  class="form-control" readonly value="{{$treasure->user->customer->username.'_'.$treasure->user->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>申請時間</label>
                                    <input  class="form-control" readonly value="{{$treasure->created_at}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>參與人數</label>
                                    <input  class="form-control" readonly value="{{count($treasure->details)}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>參與團員</label>
                                    <textarea  class="form-control" readonly>
@foreach($treasure->details as $k => $v)
@if($v->type==1)
@if($k==0){{$v->user->customer->username.'_'.$v->user->name}}@else {{$v->user->customer->username.'_'.$v->user->name}}@endif
@endif
@endforeach
                                    </textarea>
                                   
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>補登人員</label>
                                    <textarea  class="form-control" readonly>
@foreach($treasure->details as $k => $v)
@if($v->type==2)
@if($k==0){{$v->user->customer->username.'_'.$v->user->name}}@else {{$v->user->customer->username.'_'.$v->user->name}}@endif
@endif
@endforeach
                                    </textarea>
                                   
                                </div>
                            </div>


                        </div>
                   

                       

                        <div class="col-md-6">
                            <label>圖片</label>
                            @if($treasure->attachments)
                            <a href="{{url('files').'/'.$treasure->attachments->disk_directory.'/'.$treasure->attachments->disk_filename}}" data-lightbox="image" data-title="Image"> 
                                <img style="max-width: 100%;" src="{{url('files').'/'.$treasure->attachments->disk_directory.'/'.$treasure->attachments->disk_filename}}"></img>
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