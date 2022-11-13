@extends('layouts.main')

@section('title',"Register")

@section('content')
    <div class="right__title" >Add new student</div>
    <form method="post" action="{{ route('user.register') }}" enctype="multipart/form-data">
        @csrf
        @method("POST")
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required/>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required/>
        </div>

        <div class="form-group">
            <label>Full name</label>
            <input type="text" name="full_name" class="form-control" required/>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required/>
        </div>

        <div class="form-group">
            <label>Phone number</label>
            <input type="text" name="phone" class="form-control" required/>
        </div>
<!-- 
        <div class="form-group">
            <label for="avatar">Ảnh đại diện</label>
            <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
        </div> -->

        <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="1" selected >Active</option>
                <option value="0" >Inactive</option>
            </select>
        </div>

        <input style="margin-top: 24px" type="submit" class="btn btn-primary" name="register" value="Save"/>
        <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
    </form>
    <a class="btn btn-primary" href="{{ route("user.index") }}">Back</a>
@endsection
