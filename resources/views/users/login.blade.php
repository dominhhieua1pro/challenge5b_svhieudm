@extends("layouts.main_login")

@section('title', 'Login')

@section('content')
<div style="margin-top: 100px" class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading"><h4>Login</h4></div>
            <div class="panel-body">
                <form method="post" action="{{ route('login') }}" role="form">
                    @csrf
                    @method('POST')
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Username" name="username" type="text" value="{{old('username', "")}}" autofocus="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me">Remember Me
                            </label>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Login" name="login"></fieldset>
                </form>
                <div style="margin-top: 2%; ">Do not have an account?
                    <a href="{{ route('user.register') }}">
                        Register
                    </a></div>
            </div>
        </div>
    </div>
</div>
@endsection

