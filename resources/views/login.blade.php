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
    body {

      background-color: #FFF;
      margin: 0;
      padding: 0;
      font-family: var(--bs-font-sans-serif);
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;

    }
  </style>


</head>

<body class="text-center">

  <form class="mx-auto col-md-6 col-lg-2" style="margin-top: 140px;" action="{{ route('loginned') }}" method="post">
    <img src="{{asset('img') }}/logo.png" class="card-img-top" alt="Logo" style="height:200px; width:200px">
    <h1 class="h3 mb-3 fw-normal">Inicio de sesión</h1>
    @csrf
    <div class="form-floating">
      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" style="height: 60px;">
      @error('usuario')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="height: 60px;">
      @error('password')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <button class="w-100 mt-3 btn btn-lg text-white" type="submit" style="background-color: #0056b3;">Entrar</button>
  </form>


  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>

</html>