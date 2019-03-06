@extends('layouts.app')

@section('content')

<style>
td > input{
    width: 100%;
    background-color: #eee;
}
</style>

<section class="content-header">
    <h1>
      <small>{{$note->no}}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('note/sale-view')}}">業務作業</a></li>
      <li class="active">{{$note->no}}</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{url('note/sale-detail-edit').'/'.$note->id}}">編輯</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('note/note-log').'/'.$note->id}}">案件紀錄</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('note/note-statuslog').'/'.$note->id}}">流程紀錄</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(0)">#基本資料</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(1)">#個人資料</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(2)">#公司資料</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(3)">#負債狀況</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(4)">#信用異常</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(5)">#附件</button>
        </div>
       
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="box">
               
                <!--基本資料-->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">基本資料</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No</label>
                                <input  class="form-control" readonly value="{{$note->no}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>案件來源</label>
                                <input  class="form-control" readonly value="{{$source_list[$note->source_id]}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>客戶名稱</label>
                                <input  class="form-control" readonly value="{{$note->customer}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>電話</label>
                                <input  class="form-control" readonly value="{{$note->tel}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>負責業務</label>
                                <input  class="form-control" readonly value="{{$user_list[$note->assigner]}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>單據建立時間</label>
                                <input  class="form-control" readonly value="{{$note->created_at}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>備註</label>
                                <textarea  class="form-control" readonly value="{{$note->note}}"></textarea>
                            </div>
                        </div>
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>

                <!--個人資料-->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">個人資料</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>產品別</label>
                                <input  class="form-control" readonly value="{{$note->type}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>資金需求</label>
                                <input  class="form-control" readonly value="{{$note->detail->money_need}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>資金用途</label>
                                <input  class="form-control" readonly value="{{$note->detail->money_for}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>姓名</label>
                                <input  class="form-control" readonly value="{{$note->customer}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>身分證號碼</label>
                                <input  class="form-control" readonly value="{{$note->p_id}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>出生日期</label>
                                <input  class="form-control" readonly value="{{$note->birthday}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>行動電話</label>
                                <input  class="form-control" readonly value="{{$note->tel}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>婚姻狀態</label>
                                <input  class="form-control" readonly value="{{$note->detail->marital_status}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>最高學歷</label>
                                <input  class="form-control" readonly value="{{$note->detail->education_level}}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>戶籍地址</label>
                                <input  class="form-control" readonly value="{{$note->detail->permanent_address}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>戶籍電話</label>
                                <input  class="form-control" readonly value="{{$note->detail->permanent_tel}}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>現居地址</label>
                                <input  class="form-control" readonly value="{{$note->detail->contact_address}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>現居電話</label>
                                <input  class="form-control" readonly value="{{$note->detail->contact_tel}}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>居住狀況</label>
                                <input  class="form-control" readonly value="{{$note->detail->live_status}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>可提供保人</label>
                                <input  class="form-control" readonly value="{{$note->detail->have_sup}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>駕照</label>
                                <input  class="form-control" readonly value="{{$note->detail->have_driver}}">
                            </div>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                

                <!--公司資料-->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">公司資料</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>公司名稱</label>
                                <input  class="form-control" readonly value="{{$note->detail->company_name}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>統一編號</label>
                                <input  class="form-control" readonly value="{{$note->detail->company_id}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>產業別</label>
                                <input  class="form-control" readonly value="{{$note->detail->company_style}}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>公司地址</label>
                                <input  class="form-control" readonly value="{{$note->detail->company_address}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>公司電話</label>
                                <input  class="form-control" readonly value="{{$note->detail->company_tel}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>職稱</label>
                                <input  class="form-control" readonly value="{{$note->detail->company_title}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>工作年資</label>
                                <input  class="form-control" readonly value="{{$note->detail->company_exp}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>投保單位日期</label>
                                <input  class="form-control" readonly value="{{$note->detail->insure_unit}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>薪資收入</label>
                                <input  class="form-control" readonly value="{{$note->detail->pay_type}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>發薪日期</label>
                                <input  class="form-control" readonly value="{{$note->detail->pay_day}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>薪資內容</label>
                                <input  class="form-control" readonly value="{{$note->detail->pay_total}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>扣繳內容</label>
                                <input  class="form-control" readonly value="{{$note->detail->pay_cost_year}}">
                            </div>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>


                <!--負債狀況-->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">負債狀況</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!--貸款表-->
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width:10%" >授信類別</th>
                                    <th style="width:10%" >銀行</th>
                                    <th style="width:10%" >訂約金額</th>
                                    <th style="width:10%" >現欠餘額</th>
                                    <th style="width:10%" >月付金</th>
                                    <th style="width:20%" >利率/期數</th>
                                    <th style="width:10%" >核貸日期</th>
                                    <th style="width:5%" >繳款狀況</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($note->debts as $key => $value)
                                <tr>
                                    <td>
                                        <input readonly value="{{$value->class}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->bank}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->lave}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->qty}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->pay_month}}">
                                    </td>
                                    <td style="display: -webkit-box;">
                                        <input readonly style="width:30%" value="{{$value->interest}}">
                                        %
                                        <input readonly style="width:30%" value="{{$value->period}}">
                                        期
                                    </td>
                                   
                                    <td>
                                        <input readonly value="{{$value->get_day}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->pay_status}}">
                                    </td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--信用卡表-->
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>卡別</th>
                                    <th>銀行</th>
                                    <th>額度</th>
                                    <th>總欠款</th>
                                    <th>啟用日期</th>
                                    <th>繳款狀況</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($note->debts_credit as $key => $value)
                                <tr>
                                    <td>
                                        <input readonly  value="{{$value->class}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->bank}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->quota}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->total}}">
                                    </td>
                                    <td>
                                        <input readonly value="{{$value->get_day}}">
                                    </td>
                                    <td>
                                        <input readonly style="width:35%" value="{{$value->pay_status1}}">
                                        
                                        <input readonly style="width:15%" value="{{$value->pay_info1}}">天
                                        <br>
                                        <input readonly style="width:35%" value="{{$value->pay_status2}}">
                                        
                                        <input readonly style="width:15%" value="{{$value->pay_info2}}">天
                                    </td>
                                   
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>

                <!--信用異常-->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">信用異常</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>拒往</label>
                                    <input  class="form-control" readonly value="{{$note->detail->credit_error1}}">
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>退票紀錄</label>
                                    <input  class="form-control" readonly value="{{$note->detail->credit_error2}}">
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>協商</label>
                                    <input  class="form-control" readonly value="{{$note->detail->credit_error3}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>聯徵查數</label>
                                   <input  class="form-control" readonly value="{{$note->detail->credit_error4}}">
                                </div>
                            </div>
                        </div>
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>




                <!--附件-->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">附件</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @foreach($note->attachments as $key => $value)
                            <div class="col-md-12">
                                <a href="{{url('fileserver/download').'/'.$value->unique_name}}">
                                    <i class="fa fa-paperclip"></i>{{$value->filename}} ( {{$value->filesize}} - {{$value->username}} - {{$value->created_at}})
                                </a>
                            @if(strpos($value->mimetype, 'image') !== false)
                                <div style="width:100%">
                                    <img style="max-width: 100%;" src="{{url('files').'/'.$value->disk_directory.'/'.$value->disk_filename}}"></img>
                                </div>
                            @endif
                            </div>
                        @endforeach
                    </div>
                    <!-- /.box-body -->
                </div>

          
            </div>
        </div>

    </div>
    
</section>





@endsection
@section('script')
<script>
   
</script>



@endsection