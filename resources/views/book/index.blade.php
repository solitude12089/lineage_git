@extends('layouts.app')

@section('content')

<style>

</style>

   
<div class="col-12">
    <div class="panel panel-default">
        <div class="panel-body">
        	<form id='_form' class="form-horizontal" action="{{Request::url()}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	        	<h3>請選擇想製造的天書</h3>
	        	<select name="want_book">
	        		@foreach($books as $kk => $book_level)
	        			@if($kk>1)
	        			@foreach($book_level as $book)
	        				
	        					<option value="{{$book->id}}">{{$book->name}}</option>
	        				
	        			@endforeach
	        			@endif
	        		@endforeach
	        	</select>
	         

	         	<h3>已有的天數數量</h3>
	         	<div class="row">
	         		@foreach($books as $k => $book_level)
	         		@if($k < 6)
	         		<div class="col-lg-12">
	         			<h5>{{$k}} 級天書</h5>
	         			</div>
	        			@foreach($book_level as $book)
	         		<div class="col-lg-3">
	         			<label>{{$book->name}}</label>
	         			<input name="have_book[{{$book->id}}]" type="number"  min="0"></input>
	        		</div>
	        			@endforeach
	        		@endif
	        		@endforeach

	         	</div>
	           

	           	<button class="btn btn-bitbucket" type="submit" style="float: right;">計算</button>
	           </form>
        </div>
       
    </div>
</div>

@endsection



@section('script')
<script>


   
   
</script>
@endsection