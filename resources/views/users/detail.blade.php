@extends('layouts.main')

@section('title',"User Details")

@section('content')
<div class="right__title" >  User {{ $user->username }} Details </div>

@if(\Illuminate\Support\Facades\Auth::user() == $user )
<a href="{{ route('user.update',['id' => $user->id]) }}" >
    <button style="width: 140px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Edit information</button>
</a>
@elseif (\Illuminate\Support\Facades\Auth::user()->role_id==1 && $user->role_id!=1)
<a href="{{ route('user.update',['id' => $user->id]) }}" >
    <button style="width: 140px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Edit information</button>
</a>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $user->id }}</td>
    </tr>
    <tr>
        <th>Username</th>
        <td>{{ $user->username }}</td>
    </tr>
    <tr>
        <th>Full name</th>
        <td>{{ $user->full_name }}</td>
    </tr>
    <tr>
        <th>Position</th>
        <td>
            @if($user->role_id==1)
                Teacher
            @else
                Student
            @endif
        </td>
    </tr>
    <tr>
        <th>Account creator</th>
        <td>@if(!empty($owner)) <a href="{{ route("user.detail",['id' => $owner->id]) }}">{{ $owner->username }}</a> @endif </td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <th>Phone number</th>
        <td>{{ $user->phone }}</td>
    </tr>
    <tr>
        <th>Avatar</th>
        <td>
            @if(!empty($user->avatar))
            <img src="{{ asset('assets/images/avatars/'.$user->avatar) }}" height="48px"/>
            @endif
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($user->is_active)
                Active
            @else
                Inactive
            @endif
        </td>
    </tr>
    <tr>
        <th>Created at</th>
        <td>
            {{ $user->created_at }}
        </td>
    </tr>
    <tr>
        <th>Updated at</th>
        <td>
            {{ $user->updated_at }}
        </td>
    </tr>
</table>
<a style="margin-bottom: 40px" class="btn btn-primary" href="{{ route('user.index') }}">Back</a>
<div class="right__title" >  User {{ $user->username }} Messages </div>
<table class="table table-bordered">
    <tr>
        <th>Sender</th>
        <th>Receiver</th>
        <th>Content</th>
        <th>Time</th>
        <th>Edit at</th>
        <th>Action</th>
    </tr>
    @if(!empty($comments[0]))
        @foreach($comments as $comment)
            <tr >
                <td>{{ $comment->username }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $comment->content }}</td>
                <td>{{ $comment->created_at }}</td>
                <td>
                    @if($comment->created_at!=$comment->updated_at) {{ $comment->updated_at }} @else {{ $comment->created_at }} @endif
                </td>
                <td style="text-align: center;">
                    @if(\Illuminate\Support\Facades\Auth::id()==$comment->user_id)
                        <ul style="display: flex; justify-content:center;">
                            <li><a title="Update" href="{{ route('user.detail',['id' => $user->id,'comment_id'=>$comment->id]) }}"><img class="left__iconDown" src="{{asset('assets/assets/refresh.svg')}}" height="35px" alt="Edit"></a></li>
                            <li>
                                <form method="POST" action="{{ route('comment.delete',['id' => $comment->id]) }}" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="user_id1" value="{{ $user->id }}">
                                    <button style="background-color:transparent;" title="Delete" type="submit"><img style="background-color:transparent; width: 28px !important;" class="left__iconDown" src="{{asset('assets/assets/icon-trash-black.svg')}}" alt="Delete"></button>
                                </form>
                            </li>
                        </ul>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6">No messages!</td>
        </tr>
    @endif
</table>
<div class="right__title" ></div>
<form method="post" action="@if(!empty($com->content)){{ route('comment.update',['id'=>$com->id]) }}@else {{ route('comment.create') }}@endif" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="form-group">
        <input type="hidden" name="user_id1" value="{{ $user->id }}">
        <label>Message</label>
        <textarea required name="content"  id="summary" class="form-control">@if(!empty($com->content)){{$com->content}} @endif</textarea>
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="<?php echo (!empty($com->content)) ? 'Update message' : 'Send message' ?>"/>
</form>
@endsection
