@extends('layouts.app')

@section('content')

<style>
    .bar {
        width: 100px;
        height: 20px;
        margin: 2px;
        border: 1px solid black;
        background-color: lightgreen;
        text-align: center;
        float: left;
        margin: 2px;
        padding: 2px;
        cursor: pointer;
        border-radius: 3px;
    }
     
    .list {
        
        border: 1px solid gray;
    }
     
    .items .ui-selected {
        background: red;
        color: white;
        font-weight: bold;
    }
     
    .items {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100px;
        min-height: 600px;
    }
     
    .items li {
        margin: 2px;
        padding: 2px;
        cursor: pointer;
        border-radius: 3px;
    }
     
    .weekday {
        float: left;
        text-align: center;
    }
     
    .availablelist {
        background-color: orange;
        display: inline;
    }
    .job1{
        background-color: mediumpurple;
    }
    .job2{
        background-color: darkseagreen;
    }
    .job3{
        background-color: lightgoldenrodyellow;
    }
    .job4{
        background-color: lightblue;
    }
    .job5{
        color: #FFFFFF;
        background-color: #008800;
    }
    .job6{
        color: #FFFFFF;
        background-color: #3A0088;
    }
    .job7{
        color: #FFFFFF;
        background-color: #A42D00;
    }
    .job8{
        color: #FFFFFF;
        background-color: #000000;
    }
   
</style>


<section class="content-header">
    <h1>
      <small>公會成員設定 - 拖曳ID來變更血盟,記得存檔</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">公會成員設定</li>
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
                <div class="box-header">
                    <div style="display: -webkit-inline-box;">
                        <div class="job1" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">王族</div>
                    </div>


                    <div style="display: -webkit-inline-box;">
                        <div class="job2" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">騎士</div>
                    </div>


                    <div style="display: -webkit-inline-box;">
                        <div class="job3" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">妖精</div>
                    </div>

                    <div style="display: -webkit-inline-box;">
                        <div class="job4" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">法師</div>
                    </div>

                    <div style="display: -webkit-inline-box;">
                        <div class="job5" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">黑妖</div>
                    </div>


                    <div style="display: -webkit-inline-box;">
                        <div class="job6" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">槍手</div>
                    </div>

                    <div style="display: -webkit-inline-box;">
                        <div class="job7" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">龍鬥士</div>
                    </div>

                    <div style="display: -webkit-inline-box;">
                        <div class="job8" style="width: 24px;height:24px;"></div>
                        <div style="line-height: 24px;">黑暗騎士</div>
                    </div>


                   

    
                </div>
                <div class="box-body">
                    <div id="timetable">
                        <button class="btn btn-success" style="float:right" onclick="dopost()">Save</button>
                        <div class="weekday">未設定
                            @if(isset($user_list['未設定']))
                                ({{count($user_list['未設定'])}})
                            @endif
                            <ul class="items">
                                @if(isset($user_list['未設定']))
                                    @foreach($user_list['未設定'] as $key => $value)
                                        <li class="list job{{$value->job}}" value='{{$value->email}}'>{{$value->name}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        @foreach($guilds as $gk => $guild)
                            <div id="guild_{{$guild->name}}" class="weekday">{{$guild->name}}
                                @if(isset($user_list[$guild->name]))
                                    ({{count($user_list[$guild->name])}})
                                @endif
                                <ul class="items">
                                    @if(isset($user_list[$guild->name]))
                                        @foreach($user_list[$guild->name] as $key => $value)
                                            <li class="list job{{$value->job}}" value='{{$value->email}}'>{{$value->name}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                        @endforeach

                    </div>

                   
                </div>


               

          
            </div>
        </div>

    </div>
    
</section>





@endsection
@section('script')
<script>

    $(function () {
        $("#timetable .items").sortable({
                connectWith: "ul"  
        });
         
        $("ul[id^='available']").draggable({
            helper: "clone",
            connectToSortable: ".items"
        });
    });

    function dopost(){
        @foreach($guilds as $gk => $guild)
            var guild_{{$guild->name}} = [];
            $.each($('#guild_{{$guild->name}} li'),function(k,v){
                guild_{{$guild->name}}.push($(v).attr('value'));
            });
        @endforeach
        var postdata= {
            @foreach($guilds as $gk => $guild)
                '{{$guild->name}}':guild_{{$guild->name}},
            @endforeach

        };

        var url = "{{url('guild/index')}}";
        $.ajax({
          type: 'Post',
          data: postdata,
          url: url
        }).done(alert('存檔完成'));
    }
   

   
   
</script>


@endsection