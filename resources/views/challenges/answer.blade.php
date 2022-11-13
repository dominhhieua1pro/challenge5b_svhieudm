@extends('layouts.main')

@section('title',"Answer Challenge")

@section('content')
<div class="right__title" >Challenge {{ $challenge->title }} Details</div>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $challenge->id }}</td>
    </tr>
    <tr>
        <th>Teacher</th>
        <td>{{ $challenge->username }}</td>
    </tr>
    <tr>
        <th>Challenge title</th>
        <td>{{ $challenge->title }}</td>
    </tr>
    <tr>
        <th>Hint</th>
        <td>{{ $challenge->suggest }}</td>
    </tr>

    <tr>
        <th>Time created</th>
        <td>{{ $challenge->created_at }}</td>
    </tr>
</table>
<a style="margin-bottom: 40px" class="btn btn-primary" href="{{ route('challenge.index') }}">Back</a>
<div class="right__title" >Answer</div>
@if( $check==1)
    <div>
        <h2>Your answer is correct</h2>
        <h4 style="margin-top: 44px !important;">
            File content: 
            <?php
                $file = fopen(storage_path('app/public/challenges/'. $challenge->title.'.'.$answer.'.txt'), "r");
                while(!feof($file)) {
                    echo fgets($file)."<br />";
                }
                fclose($file);
            ?>
        </h4>
    </div>
@elseif($check==0)
    <h2>Your answer is incorrect</h2>
@else
    <h2>You haven't answered this challenge yet</h2>
@endif

@if( $check!=1)
<div class="right__title" ></div>
<form method="post" action="{{ route('challenge.answer',['id' => $challenge->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-group">
        <label>Enter your answer</label>
        <input type="text" name="answer" required class="form-control">
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Answer"/>
</form>
@endif
@endsection
