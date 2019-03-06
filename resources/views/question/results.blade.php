@extends('layouts.app')

@section('content')




<section class="content-header">
    <h1>
      <small>問卷調查-結果</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/question/index')}}">問卷調查</a></li>
      <li class="active"></li>
      結果
    </ol>
</section>

  
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    @foreach($question->details as $key => $value)
                                    <th>{{$value->title}}</th>
                                    @endforeach
                                    @if($question->type==2)
                                    <th>總取得鑽數</th>
                                    @endif
                                    <th>回覆人</th>
                                    <th>最後修改時間</th>

                                    
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($qas as $key => $value)
                                    <tr>
                                        @for ($i = 0; $i < count($question->details); $i++)
                                            @if($question_detail_map[$i+1]=='F')
                                            <td style="text-align:center;">
                                                <a  data-toggle="modal" data-target="#ajax-modal" href="{{url('question/pic').'/'.$value->id}}"><i class="fa fa-eye"></i></a>
                                            </td>
                                            @else
                                              <td>{{ $value['col'.($i+1)] }}</td>
                                            @endif
                                            
                                        @endfor


                                        @if($question->type==2)
                                          <td>{{$value['all_get']}}</td>
                                        @endif

                                        <td>{{ $value['user_id'] }}</td>
                                        <td>{{ $value['updated_at'] }}</td>



                                    </tr>
                                    @endforeach
                              
                            </tbody>
                        </table>
                    </form>
                </div>

          
            </div>
        </div>

    </div>
    
</section>


@endsection
@section('script')




<link rel="stylesheet" href="/dist/css/chosen.min.css">
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.quicksearch.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script src="/dist/js/chosen.jquery.min.js"></script>
<script>
    
   $('#table').DataTable(
    {
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "order": [[ 2, "desc" ]]
    });
</script>


@endsection