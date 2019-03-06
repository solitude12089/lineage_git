@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>試算結果</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('import/index')}}">入帳作業</a></li>
      <li class="active">試算結果</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{url('salary/index')}}">返回</a>
            <a class="btn btn-primary" onclick="dopost()">結算</a>
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                            <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
                            </form>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>開始時間</label>
                                    <input  class="form-control" readonly value="{{$start_day}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>結束時間</label>
                                    <input  class="form-control" readonly value="{{$end_day}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>本週城鑽所得({{$Castleimport->qty+0}}-[0 血盟補助])</label>
                                    <input  class="form-control" readonly value="{{$Castleimport->qty}}">
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>公積金(原始公積金配給({{$customer->public_scale}}%)[{{$public_money_o}}]+剩餘鑽石配給[{{$lave}}])</label>
                                    <input  class="form-control" readonly value="{{$public_money}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>補刀獎勵({{$customer->kill_scale}}%)</label>
                                    <input  class="form-control" readonly value="{{$killer_money}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>成員薪水({{$customer->member_scale}}%)</label>
                                    <input  class="form-control" readonly value="{{$salary_money}}">
                                </div>
                            </div>
                           

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>當週填表總積分(填表人數[{{$memember_count}}]+出席人數[{{$memember_count_yes}}]+傭兵人數[{{$mercenary_count}}*2])</label>
                                    <input  class="form-control" readonly value="{{$memember_point}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>薪水積分比值</label>
                                    <input  class="form-control" readonly value="{{$memember_salary}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>補刀總數</label>
                                    <input  class="form-control" readonly value="{{$killer_count}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>補刀比值</label>
                                    <input  class="form-control" readonly value="{{$killer_salary}}">
                                </div>
                            </div>
                          
                            
                            

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

    function dopost()
    {
        BootstrapDialog.show({
            message: '確認試算結果無誤?',
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