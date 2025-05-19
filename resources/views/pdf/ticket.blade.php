<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket {{$id}}</title>
</head>
<style>
    * {
        margin: 0px;
        padding: 0px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 13px;

    }

    .table {
        border: 1px solid gray;
        border-collapse: collapse;
    }

    .table td {
        border: 1px solid gray;
        padding: 3px;

    }

    .notas {
        padding: 5px 0px;
        max-width: 100%;
        /* border: 1px solid black; */
        /*border-bottom: 1px solid gray;*/
    }

    .text-muted {
       
        color: #64686A;
    }
    .table-datos{
        width: 100%;
    }

    .dotted{
        width: 100%;
        border: 1px dotted #525659;
    }
</style>

<body>
    <img src="{{public_path('img\imagen1.png')}}" alt="logo" style="position:absolute; top:0; margin-left:20px">
    <br><br><br><br>
    <div style="margin:3rem 3rem;">
        <h2 style="font-size: 1.5em;"># {{$id}} {{$tema}}</h2>
        <br>
        <hr>

        <table class="table-datos">
            <tr>
                <td><strong>Edificio:</strong> {{$edificio}}</td>
                <td><strong>Departamento:</strong> {{$departamento}}</td>
                <td><strong>Usuario:</strong> {{$reporta}} <br></td>
            </tr>
            <tr>
                <td><strong>Teléfono o EXT:</strong> {{$telefono}}</td>
                <td><strong>IP:</strong> {{$ip}}</td>
                <td><strong>Abrió el ticket:</strong> {{$creador}}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong> {{$status}}</td>
                <td><strong>Categoria:</strong> {{$categoria}}</td>
                <td><strong>Enviado:</strong> {{Carbon\Carbon::parse($created_at)->format('d/m/Y h:i:s')}}</td>
            </tr>
        </table>
        <hr><br>
        <h4 style="width: 100%; background-color:#DEDEDE; padding: 5px 0;">DESCRIPCION</h4>
        <p class="notas"> <?php echo str_replace(['style', '<li>','</li>'],['','> ','<br>' ], $descripcion); ?></p>
        
        <h4 style="width: 100%; background-color:#DEDEDE; padding: 5px 0;">COMENTARIOS</h4>
        <div style="height:520px; max-height: 520px; overflow:hidden">
            @foreach($comentarios_print as $item)
            <div style="padding:10px 0;">
                <strong>{{$item->nombre_usuario}}</strong> - <span class="text-muted">{{Carbon\Carbon::parse($item->created_at)->format('d/m/Y h:i:s')}}</span><br>
                <p class="notas"> <?php echo str_replace(['style', '<li>','</li>'],['','> ','<br>' ], $item->notas) ?></p>
            </div>
            <div class="dotted"></div>
            @endforeach
        </div>
        <br><br><br><br>
        <table style="width: 100%;">
            <tr>
                <td style="width: 45%; text-align:center;">
                    <div style="width: 200px; border: 1px solid black; margin-left:55px;"></div>
                    Atendió
                    <span>{{$asignado}}</span>
                </td>
                <td style="width: 55%; text-align:center;">
                    <div style="width: 200px; border: 1px solid black; margin-left:90px;"></div>
                    Conformidad
                </td>
            </tr>
        </table>
    </div>

    <footer>
        <div style="position:absolute; bottom:0; margin-bottom:50px; width:100%">
            <p style="text-align:center; font-size:13px;">
                “2023, Centenario de la Muerte del General Francisco Villa” <br>
                “2023, 100 años del Rotarismo en Chihuahua” <br>
                Calle Pedro N. García 2231, Col. Partido Romero, C.P. 32030. Ciudad Juárez, Chih. <br>
                Teléfonos: (656) 686 0073 y (656) 686 0001
                www.jmasjuarez.gob.mx
            </p>
        </div>
        <img src="{{public_path('img\imagen3.png')}}" alt="escudo" style="position:absolute; bottom:0; margin-bottom:30px; margin-left:10px">
        <img src="{{public_path('img\footer.png')}}" alt="pie de pagina" style="position:absolute; bottom:0;">
    </footer>
</body>

</html>