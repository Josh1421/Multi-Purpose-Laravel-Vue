@extends('layouts.app')

@section('content')
<div class="container">
  <h1>
    {{ $company->name }}
  </h1>
  <p>{{ $company->description }}</p>
  <a href="{{ route('company.edit', $company->id) }}" class="btn btn-secondary">Edit</a>
  <form action="{{ route('company.destroy', $company->id) }}" method="post">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger">Delete</button>
  </form>
</div>
@endsection
