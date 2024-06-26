<?php

use Carbon\Carbon; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico {{$dx->id}}</title>
    <style>
        @page {
            margin: 0;
        }

        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        body {
            margin-top: 100px;
            margin-bottom: 150px;
            margin-left: 25px;
            margin-right: 25px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;

        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;

        }

        table {
            border-collapse: collapse;
            width: 100%;
            padding: 2px;
        }

        th,
        td {
            border: 1px solid #D7D8D9;
            padding: 5px;
        }

        #table-diagnosticos th {
            height: 30px;
            background: #DEDEDE;
        }

        #contenedor-dictamen {
            height: 70px;
            border: 1px solid #DEDEDE;
            border-radius: 3px;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{public_path('img\imagen1.png')}}" alt="logo" style="position:absolute; left:10px; top:0;">
    </header>

    <footer>
        <div style="text-align:center; position:relative">
            <p style="font-size: 13px; color:#686662; margin-top:40px">“2023, Centenario de la Muerte del General Francisco Villa” <br>
                “2023, 100 años del Rotarismo en Chihuahua” <br>
                Calle Pedro N. García 2231, Col. Partido Romero, C.P. 32030. Ciudad Juárez, Chih. <br>
                Teléfonos: (656) 686 0073 y (656) 686 0001
                www.jmasjuarez.gob.mx</p>
            <img src="{{public_path('img\imagen3.png')}}" alt="escudo" style="position:absolute; left:0; bottom: 25px;">
            <img src="{{public_path('img\footer.png')}}" alt="pie de pagina" style="position:absolute; left:0; bottom:0; ">
        </div>
    </footer>

    <main>
        <div style="text-align: center;">
            <h3>DIAGNOSTICO DE EQUIPO DE COMPUTO</h3>
            <h4>TECNOLOGIAS DE LA INFORMACION</h4>
        </div>
        <br>
        <table>

            <tr>
                <td colspan="2"><strong>DIAGNOSTICO # {{$dx->id}}</strong></td>
                <td><strong>FECHA: </strong>{{Carbon::parse($dx->created_at)->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <td><strong>SOLICTA: </strong>{{$dx->nombre_sol}}</td>
                <td><strong>CARGO: </strong>{{$dx->cargo_sol}}</td>
                <td><strong>EXTENSION: </strong>{{$dx->ext_sol}}</td>

            </tr>
            <tr>
                <td><strong>REALIZADO POR: </strong>{{$dx->realizado}}</td>
                <td colspan="2"><strong>AREA: </strong>SOPORTE TECNICO, TI</td>
            </tr>
        </table>
        <br>
        <h4>DIAGNOSTICOS</h4>
        <table id="table-diagnosticos">
            <thead>
                <th>DSI</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Serie</th>
                <th>Diagnóstico</th>
                <th>Responsable</th>
            </thead>
            @foreach($detalle as $item)
            <tr>
                <td>{{$item->dsi}}</td>
                <td>{{$item->descripcion}}</td>
                <td>{{$item->marca}}</td>
                <td>{{$item->st}}</td>
                <td>{{$item->desc_diagnostico}}</td>
                <td>{{$item->responsable}}</td>
            </tr>
            @endforeach
        </table>
        <br>
        <h4>DICTAMEN DE AFECTACION</h4>
        <div id="contenedor-dictamen">
            {{$dx->dictamen}}
        </div>
        <table>
            <tr>
                <td style="text-align: center;">
                    Vo.Bo. Tecnologias de Información
                    <br><br><br>
                    _________________________________
                    <br><br>
                </td>
                <td style="text-align: center;">
                    Elaboró
                    <br><br><br>
                    _____________________________
                    <br><br>
                    {{$dx->realizado}}
                </td>

            </tr>
        </table>
    </main>
</body>

</html>