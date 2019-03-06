@extends('layouts.app')

@section('content')

<style>
fieldset {
    padding: .35em .625em .75em;
    margin: 0 2px;
    border: 1px solid #c0c0c0;
    margin-bottom: 20px;
    border-radius: 4px;
}
legend {
    display: block;
    width: auto;
    padding: 0px 20px;
    margin-bottom: 20px;
    font-size: 21px;
    line-height: inherit;
    color: #333;
    border: 0;
    border: 1px solid #ccc;
    background: #fff;
    border-radius: 4px;
}
</style>



<section class="content-header">
    <h1>
      <small>{{$treasure->no}} 明細</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('treasure/index')}}">寶物申報</a></li>
      <li class="active"><a href="{{url('treasure/info/'.$treasure->id)}}">{{$treasure->no}}</a></li>
      <li class="active">扣薪入帳</li>
    </ol>
</section>

  
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">



                    <fieldset >
                          <legend>原單</legend>
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
@if($k==0){{$v->user->name}}@else {{$v->user->name}}@endif
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
@if($k==0){{$v->user->name}}@else {{$v->user->name}}@endif
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




                          
                    </fieldset>

                    <fieldset >
                        <legend>申請內容</legend>

                        <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
    
                            <div class="form-group">
                              <label for="_note" class="col-sm-2 control-label">實收金額<label style="color:red">*</label></label>

                              <div class="col-sm-10">
                                <input type="number" class="form-control" id="_amount" name="_amount"/>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="_note" class="col-sm-2 control-label">照片<label style="color:red">*</label></label>

                              <div class="col-sm-10">
                                <input type="file"  class="form-control" id="_file" name="_file" accept="image/x-png,image/gif,image/jpeg"/>
                              </div>
                            </div>


                            <div style="float:right">
                                <input id="dopost" type="button" class="btn btn-primary" onclick="fn_dopost()" value='存檔'/>
                                <button type="button" class="btn btn-primary" onclick="window.history.back();">取消</button>

                            </div>
                        </form>

                    </fieldset>
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

 function fn_dopost(){
    if($('#_amount').val().length==0)
    {
      alert('請輸入實收金額!!');
      return;
    }
    if($('#_file').val().length==0)
    {
      alert('請上傳照片!!');
      return;
    }
    $('#dopost').prop('disabled', true);
    $('#addform').submit();
}

    
   
   
   
</script>


@endsection