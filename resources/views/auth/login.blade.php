@extends('layouts.app')

@section('content')

<style>

</style>

   
<div class="col-12">
    <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <form id="login_form" class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <?php $customer_list = \App\models\Customer::all()->toArray();

                    $server = isset($_GET['server'])?$_GET['server']:null ;


                ?>
                <div class="form-group">
                    <label for="customer" class="col-md-4 control-label">伺服器</label>

                    <div class="col-md-6">
                        <select id='customer'  class="form-control" name="customer">
                            @foreach($customer_list as $key => $customer)
                                @if($server!=null && $server == $customer['id'])
                                    <option value="{{$customer['id']}}" selected>{{$customer['username']}}</option>
                                @else
                                    <option value="{{$customer['id']}}">{{$customer['username']}}</option>
                                @endif
                                
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="account" class="col-md-4 control-label">帳號</label>

                    <div class="col-md-6">
                        <input id="account"  class="form-control" name="account" value="{{ old('account') }}">
                    
                    @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                    @endif
                    </div>
                </div>

                    <div class="col-md-6" style="display:none">
                        <input id="email"  class="form-control" name="email" >
                       
                    </div>
               

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">密碼</label>

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
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Remember Me
                            </label>
                            <!-- <a  class="btn btn-default btn-xs"  style='float:right' onclick='doguest()'>
                                <i class="fa fa-btn fa-sign-in"></i> Guest
                            </a> -->
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <a  class="btn btn-primary" onclick="login()">
                            <i class="fa fa-btn fa-sign-in"></i> Login
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection
@section('script')
<script>
    function doguest(){
        $('#email').val('guest');
        $('#password').val('guest');
        $('form').submit();
    }
    function login(){
        var account = $('#account').val();
        var customer = $('#customer').val();
        $('#email').val(customer+"_"+account);
        $('#login_form').submit();
    }
</script>

@endsection
