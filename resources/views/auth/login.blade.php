<form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="username" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
