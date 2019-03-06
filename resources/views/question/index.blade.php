@extends('layouts.app')

@section('content')



<section class="content-header">
    <h1>
      <small>問卷調查</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">問卷調查</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
           
          
        </div>
       
    </div>


         

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>題目</th>
                                    <th>起始日期</th>
                                    <th>結算日期</th>
                                    <th>是否回答</th>
                                    <th></th>
                                    @if(strpos(Auth::user()->role_id, '3') !== false)
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($question as $key => $value)
                                <tr>
                                    <td>{{$value->title}}</td>
                                    <td>{{$value->start_day}}</td>
                                    <td>{{$value->end_day}}</td>
                                    @if($value->end_day>=$date)
                                        @if($value->have_answer==null)
                                            <td>N</td>
                                            <td><a class='btn btn-success btn-xs' href="{{url('/question/answer/'.$value->id)}}">回覆</a></td>
                                        @else
                                            <td>Y</td>
                                            <td><a class='btn btn-primary btn-xs' href="{{url('/question/answer-edit/'.$value->id.'/'.$value->have_answer)}}">修改</a></td>
                                        @endif
                                    @else
                                        @if($value->have_answer==null)
                                            <td>N</td>
                                            <td></td>
                                        @else
                                            <td>Y</td>
                                            <td></td>
                                        @endif
                                       
                                    @endif
                                   
                                    @if(strpos(Auth::user()->role_id, '3') !== false)
                                        @if($value->type==1)
                                        <td><a  class='btn btn-success btn-xs' href="{{url('/question/results/'.$value->id)}}">結果</a></td>
                                        <td><a  class='btn btn-success btn-xs' href="{{url('/question/report/'.$value->id)}}">報表</a></td>
                                        <td><a  class='btn btn-success btn-xs' href="{{url('/question/review/'.$value->id)}}">複查</a></td>
                                            
                                       <!--  @else

                                            @if(in_array(Auth::user()->name,$special)||Auth::user()->name=='徐國勇')
                                                <td><a  class='btn btn-success btn-xs' href="{{url('/question/results/'.$value->id)}}">結果</a></td>
                                                <td></td>
                                                <td></td>
                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif
                                        @endif -->
                                    @endif


                                     
                                </tr>
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

  
   


   
</script>


@endsection