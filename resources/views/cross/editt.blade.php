@extends('layouts.app')

@section('content')

<style>

.chosen-single{
    height: 34px !important;
}
</style>


<section class="content-header">
    <h1>
      <small>{{$treasure->no}} 明細</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('treasure/index')}}">寶物申報</a></li>
      <li class="active">{{$treasure->no}}</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{url('treasure/index')}}">返回</a>
            <button id="dopost" type="button" class="btn btn-success" onclick="dopost()">存檔</button>
          
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

            <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
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
                                    <select  class="form-control chosen" name="_boss_id" required="required">
                                        @foreach($boss_list as $key => $value)
                                            <option value='{{$key}}'   {{$key==$treasure->boss_id?'selected':''}} >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>物品名稱</label>
                                    <input  class="form-control" name="_item"  value="{{$treasure->item}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>持有人</label>
                                    <select  class="form-control chosen" name="_owner">
                                          @foreach($user_list as $key => $value)
                                              <option value='{{$value->email}}'  {{$value->email==$treasure->owner?'selected':''}}>{{$value->name}}</option>
                                          @endforeach
                                    </select>
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

                           

                            <div class="form-group">
                              <label for="_members" class="col-sm-2 control-label">參與人員</label>


                              <div class="col-sm-10">
                                <select id='_members' multiple='multiple' name="_members[]">
                                  @foreach($bygroup as $key => $guild)
                                    <optgroup label='{{$key}}'>
                                    @foreach($guild as $k => $value)
                                        @if(in_array($value->email, $treasure_details))
                                            <option selected value="{{$value->email}}">{{$value->name}}</optin>
                                        @else
                                            <option value="{{$value->email}}">{{$value->name}}</optin>
                                        @endif
                                    @endforeach
                                    </optgroup>
                                  @endforeach
              
                                </select>
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
                       
                    </div>
                      <!-- /.row -->
                </div>

            </from>
            </div>
        </div>

    </div>
    
</section>




@endsection
@section('script')
<script src="/dist/js/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="/dist/css/chosen.min.css">
<link rel="stylesheet" href="/dist/css/lightbox.min.css">
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.quicksearch.js"></script>
<script src="/dist/js/lightbox.min.js"></script>

<script>

   $('.chosen').chosen({ 
    width: "95%",

    });

   function dopost () {
        $('#addform').submit();
   }
    

    $('#_members').multiSelect({
    selectableHeader: "<input type='text' style='width: 167px;' class='search-input' autocomplete='off' placeholder='請輸入收尋文字'>",
    selectionHeader: "<input type='text' style='width: 167px;'  class='search-input' autocomplete='off' placeholder='請輸入收尋文字'>",
    afterInit: function(ms){
      var that = this,
          $selectableSearch = that.$selectableUl.prev(),
          $selectionSearch = that.$selectionUl.prev(),
          selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
          selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

      that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
      .on('keydown', function(e){
        if (e.which === 40){
          that.$selectableUl.focus();
          return false;
        }
      });

      that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
      .on('keydown', function(e){
        if (e.which == 40){
          that.$selectionUl.focus();
          return false;
        }
      });
    },
    afterSelect: function(){
      this.qs1.cache();
      this.qs2.cache();
    },
    afterDeselect: function(){
      this.qs1.cache();
      this.qs2.cache();
    }
  });
   
   
   
</script>


@endsection