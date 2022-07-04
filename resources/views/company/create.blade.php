@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{ route('company.store') }}" method="POST">
      @csrf
      <div class="form-group mb-3">
        <label for="exampleInputEmail1" class="form-label">Company Name</label>
        <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
      </div>
      <div class="form-group mb-3">
        <label for="exampleInputPassword1" class="form-label">Description</label>
        <textarea name="description" cols="30" rows="5" class="form-control"></textarea>
      </div>
      <!-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div> -->
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection
