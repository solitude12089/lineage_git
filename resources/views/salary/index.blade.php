@extends('layouts.app')

@section('content')
<style>
td{
    table-layout:fixed;
}
</style>


<section class="content-header">
    <h1>
      <small>清算中心</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">清算中心</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a type="button" class="btn btn-primary" href="{{url('salary/trial')}}">薪水試算</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('salary/castleimport')}}">城鑽匯入</button>
            <label style="float: right">上次結帳日期 : {{$clearing_day!=null?$clearing_day->day:''}}</label>
          
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <!-- <div class="box">
                <div class="box-body">
                        <h2>舊制</h2>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>ID</th>
                                    <th>起始日期</th>
                                    <th>結算日期</th>
                                    <th>公積金總額</th>
                                    <th>成員薪水(40%)</th>
                                    <th>補刀獎勵(40%)</th>
                                    <th>預留金(20%)</th>

                                    <th>成員人數</th>
                                    <th>個人薪水</th>

                                    <th>補刀人頭數</th>
                                    <th>人頭薪水比</th>


                                   
                                    <th>更新日期</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salary_log as $key => $value)
                                    @if($value->status==0)
                                    <tr>
                                        <td>{{$value->id}}</td>
                                        <td>{{$value->start_day}}</td>
                                        <td>{{$value->end_day}}</td>
                                        <td>{{$value->public_money}}</td>
                                        <td>{{$value->killer_money}}</td>
                                        <td>{{$value->salary_money}}</td>
                                        <td>{{$value->reserve_money}}</td>
                                        <td>{{$value->memember_count}}</td>
                                        <td>{{$value->memember_salary}}</td>
                                        <td>{{$value->killer_count}}</td>
                                        <td>{{$value->killer_salary}}</td>
                                        <td>{{$value->updated_at}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div> -->

             <div class="box">
                <div class="box-body">
                       
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>ID</th>
                                    <th>起始日期</th>
                                    <th>結算日期</th>
                                    <th>城鑽收入</th>

                                    <th>血盟突襲補助</th>

                                    <th>成員薪水({{$customer->member_scale}}%)</th>
                                    <th>實際配發</th>
                                    <th>補刀獎勵({{$customer->kill_scale}}%)</th>
                                    <th>實際配發</th>
                                    <th>公積金({{$customer->public_scale}}%)</th>
                                    <th>實際配發</th>

                                    <th>填表人數</th>
                                    <th>出席人數</th>
                                    <th>傭兵人數*2</th>

                                    <th>填表總積分</th>
                                    <th>積分薪水比</th>


                                    <th>補刀人頭數</th>
                                    <th>人頭薪水比</th>
                                   


                                    <th>更新日期</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salary_log as $key => $value)
                                    @if($value->status==1)
                                    <tr>
                                        <td>{{$value->id}}</td>
                                        <td>{{$value->start_day}}</td>
                                        <td>{{$value->end_day}}</td>
                                        <td>{{$value->castleimport}}</td>

                                        <td>{{$value->group_sup}}</td>
                                     

                                        <td>{{$value->salary_money}}</td>
                                        <td>{{$value->memember_point*$value->memember_salary}}</td>
                                        <td>{{$value->killer_money}}</td>
                                        <td>{{$value->killer_count*$value->killer_salary}}</td>
                                        <td>{{$value->public_money_o}}</td>

                                      
                                        <td>{{$value->public_money}}</td>
                                    
                                            

                                        <td>{{$value->memember_count}}</td>
                                        <td>{{$value->memember_count_yes}}</td>
                                        <td>{{$value->mercenary_count}}</td>


                                        <td>{{$value->memember_point}}</td>
                                        <td>{{$value->memember_salary}}</td>
                                      

                                        <td>{{$value->killer_count}}</td>
                                        <td>{{$value->killer_salary}}</td>
                                        <td>{{$value->updated_at}}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>

    </div>
    
</section>


@endsection
@section('script')
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script>

  
    $('table').DataTable(
    {
        "order": [[ 1, "desc" ]],
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });
  


   
</script>


@endsection