<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificacion de tickets ASR</title>
</head>
<body>
    <p>
         
        @if($tipo == 'open')
        <strong>{{$user}}</strong> ha abierto ticket
        @else
        {{$user}} ha actualizado ticket</span>
        @endif
        <div style="font-size: 20px;color:#00BDC6;">{{$header}}</div>
        <hr>
        <div>
            <strong>Detalles:</strong><br>
            {{$descripcion}}
        </div>
        @if($cambios != '')
        <hr>
        <strong>Cambios en ticket:</strong><br> 
        <div>
            @foreach ($cambios as $item )
                {{$item->notas}} <br>
            @endforeach
        </div>
        @endif
        <br><br>
        <div><strong>Prioridad: </strong>{{$prioridad}}</div>
        <div><strong>Asignado:  </strong>{{$asignado}}</div>
        <div><strong>Creador:   </strong>{{$creator}}</div>
    </p>
</body>
</html>