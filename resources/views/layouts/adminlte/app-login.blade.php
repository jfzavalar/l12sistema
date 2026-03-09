<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app-adminlte.css', 'resources/js/app-adminlte.js'])

    @livewireStyles

    <style>
        body {
            background: #f4f6f9;
        }
        .login-card {
            max-width: 400px;
            margin: 5% auto;
        }
        .btn-login {
            background-color: #003366;
            color: white;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #002244;
        }
        .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.25);
        }
    </style>
</head>
<body class="hold-transition login-page">

<div class="login-card card card-outline card-primary">
    <div class="card-header text-center">
        <a href="#" class="h1"><b>Bienvenidos</b></a>
    </div>
    <div class="card-body">
        <p class="login-box-msg text-center">Ingrese su DNI y contraseña para iniciar sesión</p>
        {{ $slot }}
    </div>
</div>

@livewireScripts
</body>
</html>