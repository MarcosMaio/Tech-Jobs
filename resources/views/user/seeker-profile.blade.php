@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="row justify-content-center">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <form action="{{ route('user.update.profile') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="profile_pic">Profile Image</label>
                        <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                        @if (auth()->user()->profile_pic)
                            <img src="{{ Storage::url(auth()->user()->profile_pic) }}" width="150" class="mt-3">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Your name</label>
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <h2>Change your password</h2>

            <form action="{{ route('user.password') }}" method="post">@csrf
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="current_password">Your current password</label>
                        <input type="password" name="current_password"
                            class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                            id="current_password">
                        @if ($errors->has('current_password'))
                            <span class="text-danger">{{ $errors->first('current_password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Your new password</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm password</label>
                        <input type="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            name="password_confirmation" id="password_confirmation">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <h2>Update your resume</h2>

            <form action="{{ route('upload.resume') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="resume">Upload your resume</label>
                        <input type="file" name="resume"
                            class="form-control {{ $errors->has('resume') ? 'is-invalid' : '' }}"
                            id="resume">
                        @if ($errors->has('resume'))
                            <span class="text-danger">{{ $errors->first('resume') }}</span>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
            </form>
        </div>
    </div>
@endsection
