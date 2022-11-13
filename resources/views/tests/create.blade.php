@extends('layouts.main')

@section('title',"Add Assignment")

@section('content')
<div class="right__title" >Add new assignment</div>
<form method="post" action="{{ route('test.create') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-group">
        <label>Assignment name</label>
        <input type="text" name="name_test" required class="form-control"/>
    </div>

    <div class="form-group">
        <label>Assignment file</label>
        <input type="file" name="test" required class="form-control" id="category-avatar"/>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" selected >Activate</option>
            <option value="2" >Expired</option>
        </select>
    </div>

    <input style="margin-top: 24px" type="submit" class="btn btn-primary" name="submit" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
    <a class="btn btn-primary" href="{{ route("test.index") }}">Back</a>
</form>
@endsection
