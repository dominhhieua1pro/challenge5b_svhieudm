@extends('layouts.main')

@section('title',"Challenge List")

@section('content')
<div class="right__title" >Challenge List</div>
@if( \Illuminate\Support\Facades\Auth::user()->role_id==1 )
    <a href="{{ route('challenge.create') }}" >
        <button style="width: 160px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add new challenge</button>
    </a>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Teacher</th>
        <th>Challenge title</th>
        <th>Hint</th>
        <th>Time</th>
        <th>Answer</th>
        <th>Action</th>

    </tr>
    @if(!empty($challenges[0]))
        @foreach($challenges as $challenge)
            <tr>
                <td>{{ $challenge->id }}</td>
                <td>{{ $challenge->username }}</td>
                <td>{{ $challenge->title }}</td>
                <td>{{ $challenge->suggest }}</td>
                <td>{{ $challenge->created_at }}</td>
                <td><a href="{{ route('challenge.answer',['id' => $challenge->id]) }}">Answer</a></td>
                <td>
                    <ul style="display: flex; justify-content:center;">
                        <li><a title="Details" href="{{ route('challenge.answer',['id' => $challenge->id]) }}"><img style="width: 28px !important;" class="left__iconDown" src="{{asset('assets/assets/icon-edit.svg')}}" alt="Details"></a></li>
                        @if(\Illuminate\Support\Facades\Auth::id() == $challenge->user_id)
                            <li>
                                <form method="POST" action="{{ route('challenge.delete',['id' => $challenge->id]) }}" onsubmit="return confirm('Are you sure you want to delete challenge {{ $challenge->title }}?')">
                                    @method('DELETE')
                                    @csrf
                                    <button style="background-color:transparent;" type="submit"><img style="background-color:transparent; width: 28px !important;" class="left__iconDown" src="{{asset('assets/assets/icon-trash-black.svg')}}" alt="Delete"></button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">No challenges exist</td>
        </tr>
    @endif
</table>
@endsection
