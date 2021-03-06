@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-3 p-5">
            <img src="/img/logo.png" alt="profile" class="w-100">
        </div>
        <div class="col-9 p-5">

            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-4">
                    <h2>{{$user->username}}</h2>
                </div>

                <a href="/p/create" class="btn btn-primary">Add New Post</a>
            </div>

            <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
           
            <div class="d-flex">
                <div class="pe-5"><strong>12</strong> posts</div>
                <div class="pe-5"><strong>24K</strong> followers</div>
                <div class="pe-5"><strong>2K</strong> following</div>
            </div>
            
            <div class="pt-4"><strong></strong></div>
            <div></div>
            <div><a href="{{$user->profile->url}}">dsa</a></div>
        </div>
    </div>
</div>
@endsection