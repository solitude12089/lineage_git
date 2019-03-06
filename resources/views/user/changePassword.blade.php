@extends('layouts.app')

@section('content')

<style>

</style>

   
<div class="col-12">
    <div class="panel panel-default">
        <div class="panel-heading">變更密碼</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{Request::url()}}">
                {{ csrf_field() }}

             

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">新密碼</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
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
