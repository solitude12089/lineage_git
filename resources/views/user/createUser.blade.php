@extends('layouts.app')

@section('content')

<style>

</style>

   
<div class="col-12">
    <div class="panel panel-default">
        <div class="panel-heading">建立帳戶</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{Request::url()}}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="user" class="col-md-4 control-label">帳號</label>

                    <div class="col-md-6">
                        <input id="user"  class="form-control" name="user">
                    </div>
                </div>
                <div class="form-group">
                    <label for="job" class="col-md-4 control-label">職業</label>
                    <div class="col-md-6">
                        <select id="job"  class="form-control" name="job">
                            @foreach($jobs as $key => $job)
                                <option value='{{$job->id}}'>{{$job->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="guild" class="col-md-4 control-label">公會</label>
                    <div class="col-md-6">
                        <select id="guild"  class="form-control" name="guild">

                            @foreach($guild as $key => $value)
                                <option value='{{$value->name}}'>{{$value->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>
            

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-check"></i> 確定
                        </button>
                        <a href="{{ url('') }}" class="btn btn-primary">
                            <i class="fa fa-btn fa-ban"></i> 取消
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
