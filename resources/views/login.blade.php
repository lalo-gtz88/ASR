<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <title>Acceso</title>


    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
        }

        .full-screen {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .left-side {
            flex: 1;
            background: linear-gradient(to bottom right, #002b4c, #0078d4);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
        }

        .left-side img {
            max-width: 120px;
            margin-bottom: 1.5rem;
        }

        .right-side {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 4rem;
        }

        .form-control {
            margin-bottom: 1.2rem;
        }

        .btn-login {
            background-color: #0056b3;
            color: white;
        }

        .btn-login:hover {
            background-color: #004494;
        }

        .top-right {
            position: absolute;
            top: 20px;
            right: 40px;
        }

        .top-right a {
            font-size: 0.9rem;
            color: #333;
            text-decoration: none;
        }

        .top-right a.btn {
            margin-left: 1rem;
        }

        .text-small {
            font-size: 0.875rem;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .logoImg{
          height: 170px;
        }
    </style>
</head>
<body>


    <div class="full-screen">

        {{-- Columna Izquierda --}}
        <div class="left-side">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logoImg m-0">
            <h2 class="m-0">NetDesk</h2>
            <p class="mt-3">Gestión para servicios de red y tickets de servicio en TI</p>
            <small class="mt-5">Versión 3.0</small>
        </div>

        {{-- Columna Derecha --}}
        <div class="right-side mx-auto col-md-5">
            <div class="form-header">
                <h3>Iniciar sesión</h3>
                <p class="text-muted">Introduce tus credenciales para continuar</p>
            </div>

            <form action="{{ route('loginned') }}" method="POST">
                @csrf

                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" placeholder="Ingresa tu usuario" required>
                @error('usuario')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <label class="form-label mt-2">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <button type="submit" class="btn btn-login w-100 my-5">Entrar</button>
                
            </form>
        </div>

    </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>

</html>