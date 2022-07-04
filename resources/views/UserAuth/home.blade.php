<h2>Welcome {{ Session::get('user')['name'] }}</h2>
<h3>{{ Session::get('user')['username'] }}</h3>
<h3>{{ Session::get('user')['email'] }}</h3>
<h3>{{ Session::get('user')['id'] }}</h3>
<h3>{{ Session::get('user')['password'] }}</h3>

<a href="/logout">Logout</a>
