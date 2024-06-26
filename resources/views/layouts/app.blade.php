<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/js/app.js'])

    @livewireStyles
    <style>
        .input-form {
            border: 1px solid gray;
            outline: none;
            padding: 2px 10px 2px 10px;
            border-radius: 3px;
        }

        #table-tickets td {
            width: 250px;
        }

        table th {
            background-color: #012E69 !important;
            color: #FFF;
        }

        #table-tickets th,
        td {
            padding-right: 25px !important;
        }

        .navbar {
            background-color: #012E69 !important;
        }

        .btn.btn-secondary {
            background-color: #00BDC6;
            border: none;
        }

        .btn.btn-primary {
            background-color: #012E69;
            border: none;
        }

        .bg-primary {
            background-color: #012E69 !important;
        }

        .bg-secondary {
            background-color: #00BDC6 !important;
        }

        .note-insert,
        .btn-codeview,
        [data-original-title=Help] {
            display: none;
        }

        .tooltipTicket {
            position: relative;
            display: inline-block;
        }

        .tooltipTicket .tiptext {
            visibility: hidden;
            width: 420px;
            height: auto;
            overflow-y: auto;
            background-color: white;
            color: #000;
            text-align: left;
            border-radius: 3px;
            padding: 6px 10px;
            position: absolute;
            left: 0;
            margin-top: 25px;
            font-size: 14px;
            z-index: 1000;
            box-shadow: 0 5px 10px rgba(1, 1, 0, 0.2);
        }

        .tooltipTicket:hover .tiptext {
            visibility: visible;
        }
    </style>
</head>

<body>
    @component('navigation')
    @endcomponent
    {{$slot}}
    @component('toasts')
    @endcomponent


    <!-- Modal ver foto de perfil-->
    <div class="modal" id="modalVerFoto">
        <div class="modal-dialog modal-xl d-flex align-items-center justify-content-center" role="document" style="height: 85vh;">
            <img src="{{ asset('storage/perfiles').'/'. auth()->user()->photo }}" class="img-thumbnail" style="height:500px; width:500px">
        </div>
    </div>

    @livewireScripts
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>


    <script>
        $(document).ready(function() {
            $("body").tooltip({
                selector: '[data-toggle=tooltip]'
            })

            toastr.options = {
                "positionClass": "toast-bottom-right",
            }
        });

        $(document).on('alerta', event => {

            let tipo = event.detail.type;
            let msg = event.detail.msg;

            switch (tipo) {
                case 'success':
                    toastr.success(msg)
                    break
                case 'error':
                    toastr.error(msg)
                    break
                case 'warning':
                    toastr.warning(msg)
                    break
            }
        })

        $(document).on('click', "#logout", function(e) {
            e.preventDefault()
            if (confirm('¡Estas seguro que deseas salir del sistema?')) {
                $('#frmLogout').submit()
            }
        })

        $(document).on('click', '.verFoto', function(e) {
            e.preventDefault()
            $('#modalVerFoto').modal('show')
        })
    </script>
    @stack('custom-scripts')
</body>

</html>