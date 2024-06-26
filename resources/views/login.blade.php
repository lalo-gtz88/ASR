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
</head>

<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-4 mx-auto">
        <div class="card">
          <div class="card-header text-center" style="font-size: 13px; color:#012E69"><strong>HelpDesk JMAS</strong></div>
          <div class="text-center mt-3">
            <img src="{{asset('img') }}/logo.png" class="card-img-top" alt="Logo" style="height:104px;width:104px;">
          </div>
          <div class="card-body">
            <form action="{{ route('loginned') }}" method="post">
              @csrf
              <div>
                <label for="username" style="color:#012E69; font-size:13px"><strong>Usuario</strong></label>
                <input type="text" name="username" id="username" class="form-control form-control-sm">
              </div>
              @error('username')
              <small class="text-danger">{{ $message }}</small>
              @enderror
              <div>
                <label for="password" style="color:#012E69; font-size:13px"><strong>Password</strong></label>
                <input type="password" name="password" id="password" class="form-control form-control-sm">
              </div>
              @error('password')
              <small class="text-danger">{{ $message }}</small>
              @enderror
              <button class="btn btn-primary btn-block mt-2" style="background-color: #00BDC6; border:none" type="submit">Entrar</button>
            </form>
          </div>

        </div>

      </div>
    </div>
  </div>








  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>