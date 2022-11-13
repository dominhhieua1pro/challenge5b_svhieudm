@extends('layouts.main')

@section('title',"Change Avatar")

@section('content')
<div class="right__title" >Change profile avatar user {{ $user->username }} with URL</div>
<a href="{{ route("user.update",["id" => $id]) }}"><button style="width: 100px; margin-bottom: 20px" class="btn btn-primary">Back</button></a>
<form method="post" action="{{ route("user.avatar",["id"=>$id]) }}" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="form-group">
        <label>URL</label>
        <input type="text" required name="url" value="" class="form-control" />
    </div>
    <input style="margin-top: 24px" type="submit" class="btn btn-primary" name="update" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
    <a class="btn btn-primary" href="{{ route('user.update',['id' => $id]) }}">Back</a>
</form>

@endsection
