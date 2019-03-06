@extends('layouts.app')

@section('content')

<style>
.fa-remove{
    color:red;
    cursor: pointer;
}
td > input{
    width: 100%;
}
th{
    text-align: center;
}

</style>

<section class="content-header">
    <h1>
      <small>{{$note->no}}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="{{url('note/sale-view')}}">業務作業</a></li>
      <li class="active"><a href="{{url('note/sale-detail-view').'/'.$note->id}}">{{$note->no}}</a></li>
      <li class="active">編輯</li>
    </ol>
</section>


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" onclick="donext()">存擋</button>
            <a  class="btn btn-primary" href="{{url('note/sale-detail-view').'/'.$note->id}}">返回</a>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(0)">#個人資料</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(1)">#公司資料</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(2)">#負債狀況</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(3)">#信用異常</button>
            <button type="button" class="btn btn-success btn-xs" onclick="tag(4)">#附件</button>
        </div>
       
    </div>


    <form id='addform' action="{{url('note/sale-detail-edit').'/'.$note->id}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!--個人資料-->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">個人資料</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>產品別</label>
                                    <input  class="form-control" name="type" value="{{$note->type}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>資金需求</label>
                                    <input  class="form-control" name="money_need" value="{{$note->detail->money_need}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>資金用途</label>
                                    <input  class="form-control" name="money_for" value="{{$note->detail->money_for}}">
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
                                    <input  class="form-control" name="p_id" value="{{$note->p_id}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>出生日期</label>
                                    <input  class="form-control" name="birthday" value="{{$note->birthday}}">
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
                                    
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->marital_status=="未婚"?'checked="checked"':''}}  name="marital_status" value="未婚">未婚
                                        <input type="radio" {{$note->detail->marital_status=="已婚"?'checked="checked"':''}} name="marital_status" value="已婚">已婚(小孩
                                            <input style="width:20px" name="have_child" value="{{$note->detail->have_child}}">)
                                        <input type="radio" {{$note->detail->marital_status=="異離"?'checked="checked"':''}} name="marital_status" value="異離">異離
                                        <input type="radio" {{$note->detail->marital_status=="喪偶"?'checked="checked"':''}} name="marital_status" value="喪偶">喪偶
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>最高學歷</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->education_level=="國中小"?'checked="checked"':''}}  name="education_level" value="國中小">國中小
                                        <input type="radio" {{$note->detail->education_level=="高中職"?'checked="checked"':''}} name="education_level" value="高中職">高中職
                                        <input type="radio" {{$note->detail->education_level=="專科"?'checked="checked"':''}} name="education_level" value="專科">專科
                                        <input type="radio" {{$note->detail->education_level=="大學"?'checked="checked"':''}} name="education_level" value="大學">大學
                                        <input type="radio" {{$note->detail->education_level=="碩士"?'checked="checked"':''}} name="education_level" value="碩士">碩士
                                        <input type="radio" {{$note->detail->education_level=="博士"?'checked="checked"':''}} name="education_level" value="博士">博士
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>戶籍地址</label>
                                    <input  class="form-control" name="permanent_address" value="{{$note->detail->permanent_address}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>戶籍電話</label>
                                    <input  class="form-control" name="permanent_tel" value="{{$note->detail->permanent_tel}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>現居地址</label>
                                    <input  class="form-control" name="contact_address" value="{{$note->detail->contact_address}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>現居電話</label>
                                    <input  class="form-control" name="contact_tel" value="{{$note->detail->contact_tel}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>居住狀況</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->live_status=="自有"?'checked="checked"':''}}  name="live_status" value="自有">自有
                                        <input type="radio" {{$note->detail->live_status=="配偶"?'checked="checked"':''}} name="live_status" value="配偶">配偶
                                        <input type="radio" {{$note->detail->live_status=="父母"?'checked="checked"':''}} name="live_status" value="父母">父母
                                        <input type="radio" {{$note->detail->live_status=="親屬"?'checked="checked"':''}} name="live_status" value="親屬">親屬
                                        <input type="radio" {{$note->detail->live_status=="朋友"?'checked="checked"':''}} name="live_status" value="朋友">朋友
                                        <input type="radio" {{$note->detail->live_status=="租屋"?'checked="checked"':''}} name="live_status" value="租屋">租屋
                                        <input type="radio" 
                                            {{
                                                (
                                                    $note->detail->live_status!="自有"&&
                                                    $note->detail->live_status!="配偶"&&
                                                    $note->detail->live_status!="父母"&&
                                                    $note->detail->live_status!="親屬"&&
                                                    $note->detail->live_status!="朋友"&&
                                                    $note->detail->live_status!="租屋"&&
                                                    $note->detail->live_status!=""
                                                )?'checked="checked"':''}} name="live_status" >其他:
                                        <input  style="width:70px" name="live_status" value="{{$note->detail->live_status}}">
                                        &nbsp
                                        &nbsp
                                        &nbsp
                                        &nbsp
                                        居住
                                        <input style="width:20px" name="have_child" value="{{$note->detail->live_year}}">
                                        年

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>可提供保人</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->have_sup=="無"?'checked="checked"':''}}  name="have_sup" value="無">無
                                        <input type="radio" {{$note->detail->have_sup=="有"?'checked="checked"':''}} name="have_sup" value="有">有
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>駕照</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->have_driver=="無"?'checked="checked"':''}}  name="have_driver" value="無">無
                                        <input type="radio" {{$note->detail->have_driver=="有"?'checked="checked"':''}} name="have_driver" value="有">有
                                    </div>
                                </div>
                            </div>
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
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>公司名稱</label>
                                    <input  class="form-control" name="company_name" value="{{$note->detail->company_name}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>統一編號</label>
                                    <input  class="form-control" name="company_id" value="{{$note->detail->company_id}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>產業別</label>
                                    <input  class="form-control" name="company_style" value="{{$note->detail->company_style}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>公司地址</label>
                                    <input  class="form-control" name="company_address" value="{{$note->detail->company_address}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>公司電話</label>
                                    <input  class="form-control" name="company_tel" value="{{$note->detail->company_tel}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>職稱</label>
                                    <input  class="form-control" name="company_title" value="{{$note->detail->company_title}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>工作年資</label>
                                    <input  class="form-control" name="company_exp" value="{{$note->detail->company_exp}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>投保單位日期</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->insure_unit=="勞保"?'checked="checked"':''}} name="insure_unit" value="勞保">勞保
                                        <input type="radio" {{$note->detail->insure_unit=="公會"?'checked="checked"':''}}  name="insure_unit" value="公會">公會
                                        &nbsp
                                        &nbsp
                                        <input type="Date" style="width:50%" name="insure_time" value="{{$note->detail->insure_time}}">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>薪資收入</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->pay_type=="薪轉"?'checked="checked"':''}} name="pay_type" value="薪轉">薪轉
                                        &nbsp
                                        &nbsp
                                        <input style="width:30%" name="pay_bank" value="{{$note->detail->pay_bank}}">銀行
                                        <input type="radio" {{$note->detail->pay_type=="現金"?'checked="checked"':''}}  name="pay_type" value="現金">現金
                                       
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>發薪日期</label>
                                    <input  class="form-control" name="pay_day" value="{{$note->detail->pay_day}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>薪資內容</label>
                                    <input  class="form-control" name="pay_total" value="{{$note->detail->pay_total}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>扣繳內容</label>
                                    <input  class="form-control" name="pay_cost_year" value="{{$note->detail->pay_cost_year}}">
                                </div>
                            </div>
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
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <!-- 貸款表 -->
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:5%" ><button type="button" class="btn btn-success btn-xs"onclick='add_debt()'>新增</button></th>
                                        <th style="width:10%" >授信類別</th>
                                        <th style="width:10%" >銀行</th>
                                        <th style="width:10%" >訂約金額</th>
                                        <th style="width:10%" >現欠餘額</th>
                                        <th style="width:10%" >月付金</th>
                                        <th style="width:20%" >利率/期數</th>
                                        <th style="width:5%" >核貸日期</th>
                                        <th style="width:10%" >繳款狀況</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($note->debts as $key => $value)
                                    <tr>
                                        <td style='text-align: center;'><i class="fa fa-fw fa-remove" onclick="remove(this)"></i></td>
                                        <td>
                                            <input  name="debt[{{$value->id}}][class]" value="{{$value->class}}">
                                        </td>
                                        <td>
                                            <input  name="debt[{{$value->id}}][bank]" value="{{$value->bank}}">
                                        </td>
                                        <td>
                                            <input  name="debt[{{$value->id}}][lave]" value="{{$value->lave}}">
                                        </td>
                                        <td>
                                            <input   name="debt[{{$value->id}}][qty]" value="{{$value->qty}}">
                                        </td>
                                        <td>
                                            <input  name="debt[{{$value->id}}][pay_month]" value="{{$value->pay_month}}">
                                        </td>
                                        <td style="display: -webkit-box;">
                                            <input style="width:30%" name="debt[{{$value->id}}][interest]" value="{{$value->interest}}">
                                            %
                                            <input style="width:30%"  name="debt[{{$value->id}}][period]" value="{{$value->period}}">
                                            期
                                        </td>
                                       
                                        <td>
                                            <input  type="date" name="debt[{{$value->id}}][get_day]" value="{{$value->get_day}}">
                                        </td>
                                        <td>
                                            <select  name="debt[{{$value->id}}][pay_status]">
                                                <option value='正常' {{$value->pay_status=="正常"?'selected="selected"':''}} >正常</option>
                                                <option value='遲繳' {{$value->pay_status=="遲繳"?'selected="selected"':''}} >遲繳</option>
                                            </select>
                                          
                                        </td>
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- 信用卡表 -->
                            <table id="table2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:5%" ><button type="button" class="btn btn-success btn-xs"onclick='add_debt_credit()'>新增</button></th>
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
                                        <td style='text-align: center;'><i class="fa fa-fw fa-remove" onclick="remove(this)"></i></td>
                                        <td>
                                            <input  name="debt_credit[{{$value->id}}][class]" value="{{$value->class}}">
                                        </td>
                                        <td>
                                            <input  name="debt_credit[{{$value->id}}][bank]" value="{{$value->bank}}">
                                        </td>
                                        <td>
                                            <input  name="debt_credit[{{$value->id}}][quota]" value="{{$value->quota}}">
                                        </td>
                                        <td>
                                            <input   name="debt_credit[{{$value->id}}][total]" value="{{$value->total}}">
                                        </td>
                                        <td>
                                            <input  type="date" name="debt_credit[{{$value->id}}][get_day]" value="{{$value->get_day}}">
                                        </td>
                                        <td>
                                            <select  name="debt_credit[{{$value->id}}][pay_status1]">
                                                <option></option>
                                                <option value='正常' {{$value->pay_status1=="正常"?'selected="selected"':''}} >正常</option>
                                                <option value='遲繳' {{$value->pay_status1=="遲繳"?'selected="selected"':''}} >遲繳</option>
                                            </select>
                                            <input style="width:15%" name="debt_credit[{{$value->id}}][pay_info1]" value="{{$value->pay_info1}}">天
                                            <br>
                                            <select  name="debt_credit[{{$value->id}}][pay_status2]">
                                                <option></option>
                                                <option value='呆帳' {{$value->pay_status2=="呆帳"?'selected="selected"':''}} >呆帳</option>
                                                <option value='預借' {{$value->pay_status2=="預借"?'selected="selected"':''}} >預借</option>
                                            </select>
                                            <input style="width:15%" name="debt_credit[{{$value->id}}][pay_info2]" value="{{$value->pay_info2}}">天
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>拒往</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->credit_error1=="有"?'checked="checked"':''}}  name="credit_error1" value="有">有
                                        <input type="radio" {{$note->detail->credit_error1=="無"?'checked="checked"':''}} name="credit_error1" value="無">無
                                    </div>
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>退票紀錄</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->credit_error2=="有"?'checked="checked"':''}}  name="credit_error2" value="有">有
                                        <input type="radio" {{$note->detail->credit_error2=="無"?'checked="checked"':''}} name="credit_error2" value="無">無
                                    </div>
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>協商</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->credit_error3=="有"?'checked="checked"':''}}  name="credit_error3" value="有">有
                                        <input type="radio" {{$note->detail->credit_error3=="無"?'checked="checked"':''}} name="credit_error3" value="無">無
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>聯徵查數</label>
                                    <div class="form-control" style="border:none">
                                        <input type="radio" {{$note->detail->credit_error4=="有"?'checked="checked"':''}}  name="credit_error4" value="有">有
                                        <input type="radio" {{$note->detail->credit_error4=="無"?'checked="checked"':''}} name="credit_error4" value="無">無
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>


                    <!--附件-->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">附件</h3>
                            <button type="button" class="btn btn-success btn-xs"onclick='add_file()'>新增</button>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" onclick="gotop()" ><i class="fa fa-long-arrow-up"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="file_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:5%" ></th>
                                        <th style="width:10%" >檔案名稱</th>
                                        <th style="width:10%" >檔案大小</th>
                                        <th style="width:10%" >上傳日期</th>
                                        <th style="width:10%" >上傳者</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($note->attachments as $key => $value)
                                        <tr>
                                            <td style='text-align: center;'><i class="fa fa-fw fa-remove" onclick='remove(this)'></i><input style="display:none" name='attachment[]' value='{{$value->id}}'/></td>
                                            <td>{{$value->filename}}</td>
                                            <td>{{$value->filesize}}</td>
                                            <td>{{$value->updated_at}}</td>
                                            <td>{{$value->username}}</td>
                                        </tr>
                                    @endforeach
                                  
                                </tbody>
                            </table>
                            <div class="col-md-12">
                                <div  id="div_file" class="form-group">
                                    <input type="file" name="file[]">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>





              
                </div>
            </div>

        </div>
    </form>
    
</section>





@endsection
@section('script')
<script>
    var note = <?php echo json_encode($note); ?>;
    var debt_len = note.debts.length;
    var debt_credit_len = note.debts_credit.length;


    function donext()
    {
        $('#addform').submit();
    }

    function add_debt()
    {
        debt_len = debt_len+1;
        var html = "<tr>\
                        <td style='text-align: center;'><i class='fa fa-fw fa-remove' onclick='remove(this)'></i></td>\
                        <td>\
                            <input  name=debt["+debt_len+"][class]>\
                        </td>\
                        <td>\
                            <input name=debt["+debt_len+"][bank]>\
                        </td>\
                        <td>\
                            <input   name=debt["+debt_len+"][lave]>\
                        </td>\
                        <td>\
                            <input   name=debt["+debt_len+"][qty]>\
                        </td>\
                        <td>\
                            <input   name=debt["+debt_len+"][pay_month]>\
                        </td>\
                        <td style='display: -webkit-box;'>\
                            <input style='width:30%'  name=debt["+debt_len+"][interest]>\
                            %\
                            <input style='width:30%'  name=debt["+debt_len+"][period]>\
                            期\
                        </td>\
                        <td>\
                            <input type='date' name=debt["+debt_len+"][get_day]>\
                        </td>\
                        <td>\
                            <select  name=debt["+debt_len+"][pay_status]>\
                                <option value='正常' >正常</option>\
                                <option value='遲繳' >遲繳</option>\
                            </select>\
                        </td>\
                    </tr>";

        $('#table tbody').append(html);
    }
    function add_debt_credit()
    {
        debt_credit_len = debt_credit_len+1;
        var html = "<tr>\
                        <td style='text-align: center;'><i class='fa fa-fw fa-remove' onclick='remove(this)'></i></td>\
                        <td>\
                            <input  name=debt_credit["+debt_credit_len+"][class]>\
                        </td>\
                        <td>\
                            <input name=debt_credit["+debt_credit_len+"][bank]>\
                        </td>\
                        <td>\
                            <input   name=debt_credit["+debt_credit_len+"][quota]>\
                        </td>\
                        <td>\
                            <input   name=debt_credit["+debt_credit_len+"][total]>\
                        </td>\
                        <td>\
                            <input type='date' name=debt_credit["+debt_credit_len+"][get_day]>\
                        </td>\
                        <td>\
                            <select  name=debt_credit["+debt_credit_len+"][pay_status1]>\
                                <option></option>\
                                <option value='正常'>正常</option>\
                                <option value='遲繳'>遲繳</option>\
                            </select>\
                            <input style='width:10%' name=debt_credit["+debt_credit_len+"][pay_info1]>天\
                            <br>\
                            <select  name=debt_credit["+debt_credit_len+"][pay_status2]>\
                                <option></option>\
                                <option value='呆帳'>呆帳</option>\
                                <option value='預借'>預借</option>\
                            </select>\
                            <input style='width:10%' name=debt_credit["+debt_credit_len+"][pay_info2]>天\
                        </td>\
                    </tr>";

        $('#table2 tbody').append(html);
    }

    function add_file()
    {
        if(jQuery("#div_file input").filter(function() {
            return !this.value;
        }).length == 0){
            var h = '<input type="file" name="file[]">'
        $('#div_file').append(h);
        }
        
    }

    function remove(obj)
    {
        $(obj).closest( "tr" ).remove();
    }

   
</script>


@endsection