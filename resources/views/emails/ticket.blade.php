<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
</head>

<body>
    {{$datos['mensaje']}}
    <br>
    <h2>DATOS DEL TICKET</h2>
    <div><strong>TEMA</strong> {{$datos['tema']}}</div>
    <div><strong>TELEFONO</strong> {{$datos['telefono']}}</div>
    <div><strong>USUARIO</strong> {{$datos['usuario']}}</div>
    <div><strong>EDIFICIO</strong> {{$datos['edificio']}}</div>
    <div><strong>DEPARTAMENTO</strong> {{$datos['departamento']}}</div>
    <div><strong>IP</strong> {{$datos['ip']}}</div>
    <div><strong>USUARIO DE RED</strong> {{$datos['usuario_red']}}</div>
    <div><strong>AUTORIZA</strong> {{$datos['autoriza']}}</div>
    
</body>

</html> 