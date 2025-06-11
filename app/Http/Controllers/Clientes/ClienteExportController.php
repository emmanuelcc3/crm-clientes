<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClienteExportController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:clientes.exportar')->only(['exportExcel', 'exportPDF']);
    }


    public function exportExcel()
    {
        $clientes = Cliente::all();

        $filename = "clientes_" . date('Ymd_His') . ".xls";
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$filename\""
        ];

        $content = View::make('clientes.exports.excel', compact('clientes'))->render();

        return Response::make($content, 200, $headers);
    }

    public function exportPDF()
    {
        $clientes = Cliente::all();
        $html = View::make('clientes.exports.pdf', compact('clientes'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="clientes_' . date('Ymd_His') . '.pdf"');
    }
}
