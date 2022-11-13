@extends('layouts.main')

@section('title',"Assignment Details")

@section('content')
<div class="right__title" >Assignment Details</div>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $test->id }}</td>
    </tr>
    <tr>
        <th>Assignment name</th>
        <td>{{ $test->name_test }}</td>
    </tr>
    <tr>
        <th>Teacher</th>
        <td>{{ $test->username }}</td>
    </tr>
    <tr>
        <th>Download</th>
        <td>
            <a href="{{ route('test.download',['id'=>$test->id]) }}">Download</a>
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if($test->is_active)
                Activate
            @else
                Expired
            @endif
        </td>
    </tr>
    <tr>
        <th>Created at</th>
        <td>
            {{ $test->created_at }}
        </td>
    </tr>
</table>
<a class="btn btn-primary" href="{{ route('test.index') }}">Back</a>
<br> <br>

@if( \Illuminate\Support\Facades\Auth::user()->role_id!=1 )
    <div class="right__title" >Submit assignment</div>
    <form method="POST" action="{{ route('submit.create',['id'=>$test->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-group">
            <label>Choose file to submit</label>
            <input class="form-control" type="file" name="sub" required id="category-avatar"/>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
    </form>
        <br>
@endif

@if( \Illuminate\Support\Facades\Auth::user()->role_id==1 )
    <div style="margin-top: 20px" class="right__title" >List of users submitted assignment</div>
@else
    <div class="right__title" >Your submitted assignment</div>
@endif
<table class="table table-bordered">
    <tr>
        <th>Student</th>
        <th>Download</th>
        <th>Time</th>
    </tr>
    @if(!empty($submits[0]))
        @foreach($submits as $submit)
            <tr >
                <td>{{$submit->username}}</td>
                <td><a href="{{ route('submit.download',['id' => $submit->id]) }}">Download</a></td>
                <td>{{$submit->created_at}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">No users submitted</td>
        </tr>
    @endif
</table>
@endsection
