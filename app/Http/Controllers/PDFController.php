<?php

namespace App\Http\Controllers;

use App\Models\DetalleDiagnostico;
use App\Models\Diagnostico;
use App\Models\Seguimiento;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Adapter\PDFLib;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function viewDocTicket($id)
    {
        $seg = Seguimiento::leftJoin('users', 'users.id', 'seguimientos.usuario')
            ->select(DB::raw("seguimientos.*, CONCAT_WS(' ',users.name, users.lastname) AS nombre_usuario"))
            ->where('seguimientos.ticket', $id)->where('seguimientos.print', 1)->get();

        $ticket = Ticket::leftJoin('users as asignados', 'asignados.id', 'tickets.asignado')
            ->leftJoin('users as creadores', 'creadores.id', 'tickets.creador')
            ->leftJoin('users as reports', 'reports.id', 'tickets.reporta')
            ->select(DB::raw("tickets.*,
                            CONCAT_WS(' ',asignados.name,asignados.lastname) as asignado, 
                            CONCAT_WS(' ', creadores.name, creadores.lastname) as creador"))
            ->where('tickets.id', $id)
            ->first();

        $data = [

            'id' => $ticket->id,
            'tema' => $ticket->tema,
            'descripcion' => $ticket->descripcion,
            'telefono' => $ticket->telefono,
            'departamento' => $ticket->departamento,
            'ip' => $ticket->ip,
            'asignado' => $ticket->asignado,
            'edificio' => $ticket->edificio,
            'usuario_red' => $ticket->usuario_red,
            'autoriza' => $ticket->autoriza,
            'creador' => $ticket->creador,
            'prioridad' => $ticket->prioridad,
            'categoria' => $ticket->categoria,
            'creador' => $ticket->creador,
            'reporta' => $ticket->reporta,
            'status' => $ticket->status,
            'created_at' => $ticket->created_at,
            'updated_at' => $ticket->updated_at,
            'comentarios_print' => $seg,

        ];

        //dd($data);
        $pdf = Pdf::loadView('pdf.ticket', $data)->setPaper('Letter');
        return $pdf->stream('ticket' . $ticket->id . '.pdf');
    }

    public function getDocDiagnostico($id)
    {
        $dx = Diagnostico::leftJoin('users', 'users.id', 'diagnosticos.id_user')
            ->leftJoin('detalle_diagnosticos', 'detalle_diagnosticos.id_diagnostico', 'diagnosticos.id')
            ->select(DB::raw("diagnosticos.*, CONCAT_WS(' ',users.name, users.lastname) AS realizado"))
            ->where('diagnosticos.active', 1)
            ->where('diagnosticos.id', $id)->first();

        $detalle = DetalleDiagnostico::where('id_diagnostico', $id)->get();

        $data = [

            'dx' => $dx,
            'detalle' => $detalle,
        ];

        $pdf = Pdf::loadView('pdf.diagnostico', $data)->setPaper('Letter');
        return $pdf->stream('Diagnostico' . $dx->id . '.pdf');
    }
}
