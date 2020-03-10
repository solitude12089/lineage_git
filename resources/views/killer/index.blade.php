@extends('layouts.app')

@section('content')

<style>
     
      @media screen and (max-width: 480px) {
        .rwd_hide{
            display: none !important;
        }
      
      }


</style>


<section class="content-header">
    <h1>
      <small>出草申報</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">出草申報</li>
    </ol>
</section>

  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" href="{{url('killer/add')}}">新增</button>

           
        </div>
       
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="box">
              

         
                <div class="box-body">
                   
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>流水號</th>
                                    <th>出草日期</th>
                                    <th>擊殺+助攻數</th>
                                    <th class="rwd_hide">備註</th>
                                    <th>申請人</th>
                                    <th class="rwd_hide">申請時間</th>
                                    <th>照片</th>
                                   
                                    <th>刪除</th>
                                  
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($killers as $key => $value)
                                <tr>
                                   
                                    <td>{{$value->no}}</td>
                                    <td>{{$value->date}}</td>
                                    <td>{{$value->qty}}</td>
                                    <td class="rwd_hide">
                                    @if(mb_strlen($value->note,'utf8')>6)
                                        <a onclick='show_note("{{$key}}")' style="cursor: pointer;">{!!mb_substr($value->note,0,6,'utf8')!!}...</a>
                                    @else
                                        {!!$value->note!!}
                                    @endif
                                    </td>
                                    <td>{{$value->user->name}}</td>
                                    <td class="rwd_hide">{{$value->created_at}}</td>
                                    <td style="text-align:center;">
                                        <a  data-toggle="modal" data-target="#ajax-modal" href="{{url('killer/pic').'/'.$value->id}}"><i class="fa fa-eye"></i></a>
                                    </td>

                                    @if(strpos(Auth::user()->role_id, '2') !== false||$user->email==$value->user->email)

                                    <td>
                                        <form class="form-horizontal" role="form" method="POST" action="{{url('killer/delete/'.$value->id)}}">
                                            <button class="btn-pinterest">X</button>
                                        </form>
                                    </td>
                                    @else
                                    <td></td>
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




<div class="modal fade" id="modal-default" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">備註..</h4>
      </div>
      <div class="modal-body">
        <p>One fine body…</p>
      </div>
     
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


@endsection
@section('script')
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    var killers = <?php echo json_encode($killers); ?>;
    $('#table').DataTable(
    {
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "order": [[ 5, "desc" ]]
    });
   

    function show_note(str)
    {
        var s = killers[str].note;
        var html= '<pre>'+s+'</pre>';
        $('#modal-default .modal-body').empty().append(html);
        $('#modal-default').modal('show');

    }
    // BootstrapDialog.show({
    //                         title:'公告',
    //                         message: '<div>\
    //                                     <p>8/29發布最新版本</p>\
    //                                     </br>\
    //                                     <p>以下血盟列入申報出草對象</p>\
    //                                     <p>1.霸世王朝</p>\
    //                                     <p>2.小裸女抖咪咪</p>\
    //                                     <p>3.夜貓集散地</p>\
    //                                     <p>4.帥不帥看口袋</p>\
    //                                     <p>5.巔峰會館</p>\
    //                                     <p>6.兵分三路</p>\
    //                                     <p>7.監獄風雲</p>\
    //                                     <p>8.呆呆聯盟</p>\
    //                                     <p>9.飄凌映雪</p>\
    //                                     <p>10.狼嗥之殿</p>\
    //                                     <p>11.風流當鋪</p>\
    //                                     <p>12.歲月不饒人</p>\
    //                                     <p>13.楓居蕥閣(8/20新增)</p>\
    //                                     <p>13.14三生三世十里桃花(8/29新增)</p>\
    //                                     </br>\
    //                                     <p>特例:水果小號打幣機、已退盟但確定是敵隊人物、對方小號，都算申報對象。</p>\
    //                                     </br>\
    //                                     <p>以下血盟為對方小號盟或白木盟，可設敵盟，但"不"列入出草申報對象</p>\
    //                                     <p>1.清沁茶坊</p>\
    //                                     <p>2.Supreme</p>\
    //                                     <p>3.清心福全</p>\
    //                                     <p>4.王者天下</p>\
    //                                     <p>5.明哲保身</p>\
    //                                     <p>6.不二家一人攻城</p>\
    //                                 </div>',
    //                     });

</script>


@endsection