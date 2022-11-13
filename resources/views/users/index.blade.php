@extends('layouts.main')

@section('title',"User List")

@section('content')
<div class="right__title" >Welcome {{ \Illuminate\Support\Facades\Auth::user()->full_name }}. You are a {{ (\Illuminate\Support\Facades\Auth::user()->role_id==1) ? 'Teacher' : 'Student' }}</div>
<div class="right__title" >User List</div>
@if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
    <a href="{{ route('user.register') }}" >
        <button style="width: 140px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add new student</button>
    </a>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Full name</th>
        <th>Position</th>
        <th>Avatar</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    @if(!empty($users[0]))
        @foreach($users as $user)
            <tr >
                <td>{{ $user->id }}</td>
                <td><a href="{{ route('user.detail', ['id' => $user->id]) }}">{{ $user->username }}</a></td>
                <td>{{ $user->full_name }}</td>
                <td>{{ ($user->role_id == 1) ? 'Teacher' : 'Student' }}</td>
                <td>
                    @if(!empty($user->avatar))
                        <img style="height: 64px;" src="{{ asset('assets/images/avatars/'.$user->avatar) }}"/>
                    @else
                        <img style="height: 64px;" src="{{ asset('assets/images/avatars/default-avatar.png') }}"/>
                    @endif
                </td>
                <td>@if ($user->is_active)
                        Active
                    @else
                        Inactive
                    @endif
                </td>
                <td style="text-align: center; ">
                    <ul style="display: flex; justify-content:center;">
                        <li><a title="Details" href="{{ route('user.detail',['id' => $user->id]) }}"><img style="width: 28px !important;" class="left__iconDown" src="{{asset('assets/assets/icon-edit.svg')}}" alt="Details"></a></li>
                        @if( \Illuminate\Support\Facades\Auth::id()==$user->id )
                            <li><a title="Update" href="{{ route('user.update',['id' => $user->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/refresh.svg')}}" height="35px" alt="Edit"></a></li>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id==1 && $user->role_id!=1 )
                            <li><a title="Update" href="{{ route('user.update',['id' => $user->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/refresh.svg')}}" height="35px" alt="Edit"></a></li>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id==1 && \Illuminate\Support\Facades\Auth::id()!=$user->id && $user->role_id!=1 )
                            <li>
                            <form method="POST" action="{{ route('user.delete',['id' => $user->id]) }}" onsubmit="return confirm('Are you sure you want to delete user {{ $user->username }}?')">
                                @method('DELETE')
                                @csrf
                                <button style="background-color:transparent" title="Delete" type="submit"><img style="background-color:transparent; width: 28px !important;" class="left__iconDown" src="{{asset('assets/assets/icon-trash-black.svg')}}" alt="Delete"></button>
                            </form>
                            </li>
                        @endif
                    </ul>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">No users exist</td>
        </tr>
    @endif
</table>
@endsection
