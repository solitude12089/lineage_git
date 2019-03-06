@extends('layouts.app')

@section('content')




<section class="content-header">
    <h1>
      <small>問卷調查-複查</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/question/index')}}">問卷調查</a></li>
      <li class="active"></li>
      複查
    </ol>
</section>



<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              @foreach($guilds as $g_k => $guild)
                @if($g_k==0)
                  <li class="active"><a href="#{{$guild->name}}" data-toggle="tab" aria-expanded="true">{{$guild->name}}</a></li>
                @else
                  <li><a href="#{{$guild->name}}" data-toggle="tab" aria-expanded="true">{{$guild->name}}</a></li>
                @endif
              @endforeach
            </ul>
            <div class="tab-content">
              @foreach($guilds as $g_k => $guild)
                  <div class="tab-pane {{$g_k==0?'active':''}}" id="{{$guild->name}}">
                    <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    @foreach($question->details as $key => $value)
                                    <th>{{$value->title}}</th>
                                    @endforeach
                                    <th>填寫人</th>
                                    <th>複查確認</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($qas as $key => $value)
                                      @if($value->col2==$guild->name)
                                      <tr>
                                          <td hidden>{{ $value['id']}}</td>
                                          <td>
                                            <select>
                                              <option value='會' {{$value['col1']=='會'?'selected':''}}>會</option>
                                              <option value='不會' {{$value['col1']=='不會'?'selected':''}}>不會</option>
                                            </select>
                                          </td>
                                          @for ($i = 1; $i < count($question->details); $i++)
                                              <td>{{ $value['col'.($i+1)] }}</td>
                                          @endfor
                                          <td>{{ $value['user_id'] }}</td>
                                          <td>
                                            <a class='btn btn-primary btn-xs' onclick="do_post(this)">確認</a>
                                          </td>
                                      </tr>
                                      @endif
                                    @endforeach
                              
                            </tbody>
                    </table>
                  </div>
              @endforeach
             
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>


@endsection
@section('script')




<link rel="stylesheet" href="/dist/css/chosen.min.css">
<link rel="stylesheet" href="/dist/css/multi-select.css">
<script src="/dist/js/jquery.multi-select.js"></script>
<script src="/dist/js/jquery.quicksearch.js"></script>
<script src="/dist/js/jquery.countdown.min.js"></script>
<script src="/dist/js/chosen.jquery.min.js"></script>
<script>
    function do_post (obj) {
      var url = "{{url('/question/review')}}";
      var tr = $(obj).closest('tr');
      var _id = $(obj).closest('tr').find('td').first().text();
      var _col1 = $(obj).closest('tr').find('select').val();

    
      var postdata = {
        'id':_id,
        'col1':_col1
      }
      $.ajax({
        type: 'Post',
        data: postdata,
        url: url
      });


      tr.remove();
    
    }
 
</script>


@endsection