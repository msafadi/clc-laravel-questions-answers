@extends('layouts.default')

@section('title', 'Edit Profile')

@section('content')

<div class="row">
    <div class="col-md-9">
        <form action="{{ route('password.change') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <x-form-input type="password" name="current_password" label="Current Password" />
            </div>
            <div class="form-group mb-3">
                <x-form-input type="password" name="password" label="New Password" />
            </div>
            <div class="form-group mb-3">
                <x-form-input type="password" name="password_confirmation" label="Confirm Password" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection