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
            <a class="btn btn-primary" onclick="dopost()">新增出價</a>
            @if($auction_detail!=null)
                <form id="deleteform" style="display: -webkit-inline-box;" action="{{url('auction/delete-offer'.'/'.$auction->id)}}" method="post">
                    <input class="btn btn-danger" onclick="dodelete()"  value="棄標(目前出價{{$auction_detail->price}})"/>
                </form>
                

            @endif
        </div>
       
    </div>


         

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
                                    <label>目前價格</label>
                                    <input  class="form-control" readonly value="{{$auction->now_price}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>目前得標者</label>
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
                

          
            </div>
        </div>

    </div>
    
</section>





@endsection
@section('script')
<link rel="stylesheet" href="/dist/css/lightbox.min.css">
<script src="/dist/js/lightbox.min.js"></script>

<script>


    function dopost()
    {
        BootstrapDialog.show({
            title:'新增出價',
            message: '請輸入最大競標金額  (最小出價單位 : {{$unit}} )\
            <form id="addform" action="{{url('auction/offer'.'/'.$auction->id)}}" method="post">\
                <input type="number" min="{{$auction->min_price}}" class="form-control"  name="post_price" step="{{$unit}}" required>\
            </form>',
            buttons: [
                {
                    label: '確定',
                    cssClass: 'btn-success',
                    action: function(dialogRef) {
                        var price = dialogRef.getModalBody().find('input').val();

                        if(price.length==0)
                        {
                            alert('請輸入金額!!!');
                            return;
                        }
                        if(price < {{$auction->min_price}}){
                            alert('金額不可小於起標價!!!');
                            return;
                        }
                        if(price%{{$unit}}!=0){
                            alert('競標價格需要為 {{$unit}} 的倍數!!!');
                            return;
                        }
                        else
                        {
                            $('#post_price').val(price);
                            $('#addform').submit();

                        }

                        
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

    function dodelete(){
        BootstrapDialog.show({
            title:'棄標',
            message: '是否棄標該商品???',
            buttons: [
                {
                    label: '確定',
                    cssClass: 'btn-success',
                    action: function(dialogRef) {
                            $('#deleteform').submit();
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