<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('css/leaflet.css')}}" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <style>
        /* Sidebar visible en pantallas grandes */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(to bottom right, #002b4c, #0078d4);
            color: white;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: white;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu li {
            padding: 5px 5px;
            list-style: none;

        }

        trix-toolbar [data-trix-action="attachFiles"] {
            display: none;
        }

        /* Ajuste del contenido */
        .content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Ocultar sidebar en móviles y usar offcanvas */
        @media (max-width: 991px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>

</head>

<body>


    @component('navigation')
    @endcomponent

    <!-- Contenido Principal -->
    <div class="main-content">


        <main>
            @yield('content')
        </main>

    </div>

    <!-- Modal ver foto de perfil-->
    <div class="modal" id="modalVerFoto">
        <div class="modal-dialog modal-xl d-flex align-items-center justify-content-center" role="document" style="height: 85vh;">
            <img src="{{ asset('storage/perfiles').'/'. auth()->user()->photo }}" class="img-thumbnail" style="height:500px; width:500px">
        </div>
    </div>

    @livewireScripts

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <!-- Leaflet's script -->
    <script src="{{asset('js/leaflet.js')}}"></script>
    <!-- scripts propios -->
    <script src="{{asset('js/app.js')}}"></script>

    @stack('custom-scripts')
</body>

</html>