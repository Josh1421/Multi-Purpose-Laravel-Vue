<h3>Register</h3>

@if(Session::has('success'))
<p>{{ Session::get('success') }}</p>
@endif

<form action="/register/validate" method="post">
  @csrf
  <label for="">Name: </label>
  <input type="text" name="name"  id="name" class="@error('name') is-invalid @enderror"><br>
  @error('name')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  <label for="">Email: </label>
  <input type="text" name="email"  id="email" class="@error('email') is-invalid @enderror"><br>
  @error('email')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  <label for="">Username: </label>
  <input type="text" name="username"  id="username" class="@error('username') is-invalid @enderror"><br>
  @error('username')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  <label for="">Password: </label>
  <input type="password" name="password"  id="password" class="@error('password') is-invalid @enderror"><br>
  @error('password')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  <button type="submit">Register</button>

  <p>Go back to <a href="/login">Login</a></p>
</form>