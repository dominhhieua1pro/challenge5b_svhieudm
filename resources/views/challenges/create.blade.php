@extends('layouts.main')

@section('title',"Add New Challenge")

@section('content')
<div class="right__title" >Add New Challenge</div>
<form method="post" action="{{ route('challenge.create') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-group">
        <label>Challenge title</label>
        <input type="text" name="title" required value="" class="form-control"/>
    </div>
    <div class="form-group">
        <label>Hint</label>
        <input type="text" name="suggest" required value="" class="form-control"/>
    </div>

    <div class="form-group">
        <label>Challenge file (Only .txt file)</label>
        <input type="file" accept=".txt" name="challenge" required class="form-control" id="category-avatar"/>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" selected >Active</option>
            <option value="0" >Inactive</option>
        </select>
    </div>

    <input style="margin-top: 24px" type="submit" class="btn btn-primary" name="submit" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
    <a class="btn btn-primary" href="{{ route('challenge.index') }}">Back</a>
</form>
@endsection
