@extends('layouts.app')

@section('content')

<style>
    .content {
        min-height: 20px;
    }
    .pretty-select {
  /*移除箭頭樣式*/
  appearance:none;
  -moz-appearance:none;
  -webkit-appearance:none;

  /*改變右邊箭頭樣式*/
  background: url("/dist/img/down.png") no-repeat right center transparent;
  
  border:0px;
  width:70%;
  height:34px;
  padding-left:2px;
  padding-right:40px;
  background-color:#F6F7F7;
  color:gray;
}

/*IE隱藏箭頭樣式*/
.pretty-select::-ms-expand { 
  display: none; 
}

.pretty-select:focus{
  box-shadow: 0 0 5px 2px #467BF4;    
}
</style>

<section class="content-header">
    <h1>
      <small>問卷調查</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/question/index')}}">問卷調查</a></li>
      <li class="active"></li>
      修改
    </ol>
</section>


<div style="background:#FFFFFF">
    <H1 style="padding:20px">{{$question->title}}</H1>

    <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
        @foreach($question->details as $qk => $qv)
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{$qv->title}}</h3>
                            </div>
                            
                            <div class="box-body">
                               
                                @if($qv->code_type=="S")
                                    <select class="pretty-select" name="col{{$qk+1}}">
                                        @foreach($qv->option as $ok => $ov)
                                            <option value="{{$ov}}">{{$ov}}</option>
                                        @endforeach
                                    </select>
                                @endif
                                @if($qv->code_type=="I")
                                  <input class="form-control" name="col{{$qk+1}}"/>
                                @endif
                                @if($qv->code_type=="T")
                                  <textarea class="form-control" name="col{{$qk+1}}"></textarea>
                                @endif
                                
                                @if($qv->code_type=="F")
                                  <input type='file' class="form-control" name="col{{$qk+1}}"  accept="image/gif, image/jpeg"/>
                                @endif
                                @if($qv->code_type=="M")
                                    <select class="form-control chosen"  multiple name="col{{$qk+1}}[]">
                                        @foreach($qv->option as $ok => $ov)
                                            <option value="{{$ov}}">{{$ov}}</option>
                                        @endforeach
                                    </select>
                                @endif
                              
                               <!--  <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input type="file" id="exampleInputFile">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox"> Check me out
                                    </label>
                                </div> -->
                            </div>
                           
                            
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
        <div style="padding:15px" class="box-footer">
            <button style="float:right" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

<div>


@endsection
@section('script')
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script src="/dist/js/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="/dist/css/chosen.min.css">
<script>
var question_detail_map = <?php echo json_encode($question_detail_map); ?>;
var qa =  <?php echo json_encode($qa); ?>;

$.each(qa,function(k,v){
    if(v!=null){
        if($('[name^="'+k+'"]').length>0){
            if(question_detail_map[k.substr(3,k.length-1)]=='M'){
              var mv = v.split(',');
              $('[name^="'+k+'"]').val(mv);
              console.log(v);
            }
            else{
              $('[name="'+k+'"]').val(v);
            }
            
        }
    }

});
$('.chosen').chosen();
   


   
</script>


@endsection