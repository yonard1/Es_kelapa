<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Es Kelapa</title>
    <link rel="stylesheet" href="{{asset('css/bootstra.min.css')}}">
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(120deg, #4facfe, #00f2fe);
            display:flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin:0;
        }
        .card{
            background:#fff;
            padding:2rem;
            border-radius:15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            width:350px;
            text-align:center;
        }
        h2{
            margin-bottom:1rem;
            color:#333;
        }
        input{
            width:80%;
            padding:10px;
            margin: 8px 0;
            border-radius: 8px;
            border:1px solid #ccc;
            outline:none;
            transision:0.3s;
        }
        input:focus{
            border-color: #4facfe;
            box-shadow: 0 0 5px #4facfe;
        }
        button{
            width: 87%;
            padding:10px;
            border-radius:8px;
            border:none;
            background:#4facfe;
            color:white;
            font-weight:bold;
            cursor: pointer;
            transition:0.3s;
        }
        button:hover{
            background:#00c6ff;
        }
        .link{
            margin-top:10px;
            font-size:14px;
        }
        .link a{
            text-decoration: none;
            color:#4facfe;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>Login</h2>
    @if (session('error'))
        <p style="color: red;">{{session('error')}}</p>
    @endif
    <form method="POST" action="{{route('login.post')}}">
        @csrf
        <input type="text" name="username" placeholder="Username" required autofocus>
        <input type="password" name="password" placeholder="Password" required autofocus>
        <button type="submit">Login</button>
    </form>
    <div class="link">
        Belum punya akun? <a href="{{route('register.form')}}">Daftar</a>
    </div>
</div>
</body>
</html>
