<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
</head>
<body>

<div class="wrapper">
    <div class="container">
        <div class="dashboard">
            <div class="left">
                    <span class="left__icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                <div class="left__content">
                    <a style="margin-left: 16px; text-decoration: none;" class="left__logo" href="{{ route('user.index') }}">Student Management</a>
                    <div class="left__profile">
                        <div class="left__image">
                            <a href="{{ route("user.detail",["id" => \Illuminate\Support\Facades\Auth::id()]) }}">
                                <img style="height:160px;"  src="{{ asset("assets/images/avatars/". ((\Illuminate\Support\Facades\Auth::user()->avatar) ? \Illuminate\Support\Facades\Auth::user()->avatar : 'default-avatar.png') ) }}"/></a>
                        </div>
                        <a  href="{{ route("user.detail",["id" => \Illuminate\Support\Facades\Auth::id()]) }}"><p style="font-size: 16px;" class="left__name">{{ \Illuminate\Support\Facades\Auth::user()->full_name}}</p></a>
                    </div>
                    <ul class="left__menu">
                        <li class="left__menuItem">
                            <div class="left__title"><img src="{{asset('assets/assets/icon-user.svg')}}" alt="">Users<img class="left__iconDown" src="{{asset('assets/assets/arrow-down.svg')}}" alt=""></div>
                            <div class="left__text">
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                <a class="left__link" href="{{ route('user.register') }}">Add New Student</a>
                                @endif
                                <a class="left__link" href="{{ route('user.index') }}">Show All Users</a>
                            </div>
                        </li>

                        <li class="left__menuItem">
                            <div class="left__title"><img src="{{asset('assets/assets/icon-edit.svg')}}" alt="">Assignments<img class="left__iconDown" src="{{asset('assets/assets/arrow-down.svg')}}" alt=""></div>
                            <div class="left__text">
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                <a class="left__link" href="{{ route('test.create') }}">Add New Assignment</a>
                                @endif
                                <a class="left__link" href="{{ route('test.index') }}">Show All Assignments</a>
                            </div>
                        </li>

                        <li class="left__menuItem">
                            <div class="left__title"><img src="{{asset('assets/assets/icon-tag.svg')}}" alt="">Challenges<img class="left__iconDown" src="{{asset('assets/assets/arrow-down.svg')}}" alt=""></div>
                            <div class="left__text">
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                <a class="left__link" href="{{ route('challenge.create') }}">Add New Challenge</a>
                                @endif
                                <a class="left__link" href="{{ route('challenge.index') }}">Show All Challenges</a>
                            </div>
                        </li>

                        
                        
                        <li class="left__menuItem">
                            <a href="{{ route('user.logout') }}" class="left__title"><img src="{{ asset('assets/assets/icon-logout.svg')}}" alt="">Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="right">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
        <div class="right__content">
            <div class="right__table">

                <div> @yield('content') </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

<script src="{{asset('assets/js/main.js')}}"></script>

</body>
</html>
