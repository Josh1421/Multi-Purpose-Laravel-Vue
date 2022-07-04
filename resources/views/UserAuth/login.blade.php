<h3>Login</h3>

@if(Session::has('failed'))
<p>{{ Session::get('failed') }}</p>
@endif

<form action="/login/validate" method="post">
  @csrf

  <label for="">Email: </label>
  <input type="text" name="email"  id="email" class="@error('email') is-invalid @enderror"><br>
  @error('email')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  <label for="">Password: </label>
  <input type="password" name="password"  id="password" class="@error('password') is-invalid @enderror"><br>
  @error('password')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror

  <button type="submit">Login</button><br>
  <a href="/register">Register</a>
</form>