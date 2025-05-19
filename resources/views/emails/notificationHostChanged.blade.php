<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificacion de Servicios de Red</title>
</head>
<body>
    @if($status == 'offline')
    <h2 style="color: red;">🚨 ALERTA: Dispositivo fuera de línea</h2>
    <div><strong>Estado:</strong> 🔴 INACTIVO</div>
    <div><strong>Fecha y Hora:</strong> {{ Carbon\Carbon::parse(now())->format('d/m/Y H:i:s') }}</div>
    <div><strong>Dispositivo:</strong> {{$device->relDispositivo->relTipoEquipo->nombre}} </div>
    <div><strong>IP:</strong> {{$device->direccion_ip}}</div>
    <p>El sistema ha detectado que el dispositivo {{$device->relDispositivo->relTipoEquipo->nombre}} - {{$device->direccion_ip}} no responde.</p>
    <p>Por favor, verifica la conexión lo antes posible.</p>
    @endif
    
    @if($status == 'online')
    <h2 style="color: green;">✅ [OK] Conexión restaurada</h2>
    <div><strong>Estado:</strong> 🟢 ACTIVO</div>
    <div><strong>Fecha y Hora:</strong> {{ Carbon\Carbon::parse(now())->format('d/m/Y H:i:s') }}</div>
    <div><strong>Dispositivo:</strong> {{$device->relDispositivo->relTipoEquipo->nombre}} </div>
    <div><strong>IP:</strong> {{$device->direccion_ip}}</div>
    <p>El sistema ha detectado que la conexion del dispositivo {{$device->relDispositivo->relTipoEquipo->nombre}} - {{$device->direccion_ip}} ha sido restaurada.</p>
    @endif
    
    <br>
    <p>Saludos,<br> Sistema de Monitoreo</p>

</body>
</html>