@extends('layouts.app')

@section('content')

<style>

</style>

   
<div class="col-12">
    <div class="panel panel-default">
       <button id='AA' onclick='op()'>Test</button>
    </div>
</div>

@endsection
@section('script')
 
<script>

    function op(){
        var myWindow = window.open("", "MsgWindow", "width=200,height=100");
        myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");
    }
</script>
@endsection
