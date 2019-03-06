@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>{{$treasure->no}} 明細</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('import/index')}}">入帳作業</a></li>
      <li class="active">{{$treasure->no}}</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{url('import/index')}}">返回</a>

             @if(strpos(Auth::user()->role_id, '5') !== false)
                <a class="btn btn-danger" onclick="dorollback()">回溯</a>
            @endif
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

                <form id='addform' class="form-horizontal" action="{{url('import/dorollback'.'/'.$treasure->id)}}" method="post">
                    
                </form>
         
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
                                    <label>物品名稱</label>
                                    <input  class="form-control" readonly value="{{$treasure->item}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>持有人</label>
                                    <input  class="form-control" readonly value="{{$treasure->owner_name->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>申請人</label>
                                    <input  class="form-control" readonly value="{{$treasure->user->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>申請時間</label>
                                    <input  class="form-control" readonly value="{{$treasure->created_at}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>入帳金額</label>
                                    <input  class="form-control" readonly value="{{$treasure->really_price}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>覆核者</label>
                                    <input  class="form-control" readonly value="{{isset($user_map[$treasure->assentor])?$user_map[$treasure->assentor]:$treasure->assentor}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>入帳時間</label>
                                    <input  class="form-control" readonly value="{{$treasure->updated_at}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>參與團員</label>
                                    <textarea  class="form-control" readonly>
@foreach($treasure->details as $k => $v)
@if($k==0){{$v->user->name}}@else,{{$v->user->name}}@endif
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
    function dorollback(){
        BootstrapDialog.show({
            message: '是否確認 回溯 該單據?????',
            buttons: [
                {
                    label: '確定',
                    cssClass: 'btn-success',
                    action: function(dialogRef) {
                            $('#addform').submit();
                    }
                    
                },
                {
                    label: 'Close',
                    action: function(dialogRef) {
                        dialogRef.close();
                    }
                }


            ]
        });
    }
   
   
   
</script>


@endsection