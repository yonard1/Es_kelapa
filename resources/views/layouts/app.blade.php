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
                    <a href="{{route('dashboard')}}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('product.index')}}" class="nav-link">Produk</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('material.index')}}" class="nav-link">Bahan</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link"></a>
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
