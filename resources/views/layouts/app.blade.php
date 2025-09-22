<!DOCTYPE html>
<html>
<head>
    <title>CRUD Produk</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">Es Kelapa</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ Auth::user()->hak === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('product.index')}}" class="nav-link">Produk</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('material.index')}}" class="nav-link">Bahan</a>
                </li>
                <li class="nav-item">
                    @if(Auth::user()->hak === 'admin')
                        <a href="{{ route('users.index') }}" class="nav-link">Kelola Pengguna</a>
                    @endif
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-sm bg-primary">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
