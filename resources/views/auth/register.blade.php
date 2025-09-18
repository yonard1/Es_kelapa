<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nama" required>
    <input type="username" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
    <button type="submit">Daftar</button>
</form>
