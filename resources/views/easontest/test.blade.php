@extends('layouts.app')

@section('content')


<section class="content-header">
    <h1>
      <small>建檔作業</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">建檔作業</li>
    </ol>
</section>

  
<form id='nextform' class="form-horizontal" action="{{url('easontest/up-view')}}" method="post" enctype="multipart/form-data">
    <input type="file" name="file[]" />
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button>submit</button>
</form>



@endsection
@section('script')
<script>

</script>


@endsection