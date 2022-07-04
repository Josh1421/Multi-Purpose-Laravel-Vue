@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex">
      <div class="pe-3"><h2>Click to create</h2></div>
      <div><a href="{{ route('company.create') }}" class="btn btn-primary">Create Company</a></div>
    </div>

    <br/>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Company Name</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($companies as $company )
          <tr>
            <th scope="row">{{ $company->id }}</th>
            <td>{{ $company->name }}</td>
            <td>{{ $company->description }}</td>
            <td>
              <a href="{{ route('company.show', $company->id ) }}">Show</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    
</div>
@endsection
