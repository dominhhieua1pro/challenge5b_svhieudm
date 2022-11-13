@extends('layouts.main')

@section('title',"Assignment List")

@section('content')
<div class="right__title" >Assignment List</div>
@if( \Illuminate\Support\Facades\Auth::user()->role_id==1 )
    <a href="{{ route('test.create') }}" >
        <button style="width: 168px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add new assignment</button>
    </a>
@endif
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Teacher</th>
        <th>Assignment</th>
        <th>Download</th>
        <th>Time</th>
        <th>Status</th>  
        <th>Action</th>
    </tr>
    @if(!empty($tests[0]))
        @foreach($tests as $test)
          <tr>
              <td>{{ $test->id }}</td>
              <td>{{ $test->username }}</td>
              <td><a href="{{ route('test.detail',['id'=>$test->id]) }}">{{ $test->name_test }}</a></td>
              <td>
                  <a href="{{route('test.download',['id'=>$test->id])}}">Download</a>
              </td>
              <td>{{ $test->created_at }}</td>
              <td>{{ ($test->is_active == 1) ? 'Activate' : 'Expired' }}</td>
              <td>
                  <ul style="display: flex; justify-content:center;">
                      <li><a title="Details" href="{{ route('test.detail',['id'=> $test->id]) }}"><img style="width: 28px !important;" class="left__iconDown" src="{{asset('assets/assets/icon-edit.svg')}}" alt="Details"></a></li>
                      @if(\Illuminate\Support\Facades\Auth::user()->role_id==1 && \Illuminate\Support\Facades\Auth::id()==$test->user_id)
                          <li>
                              <form method="POST" action="{{ route('test.delete',['id' => $test->id]) }}" onsubmit="return confirm('Are you sure you want to delete this assignment {{ $test->name_test }}?')">
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
          <td colspan="7">No assignments exist</td>
      </tr>
    @endif
</table>
@endsection

