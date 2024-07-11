<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\Sale;
use Carbon\Carbon;
use PDF;

class SaleController extends Controller
{
    const MODULE = 'Ventas';

    public function index(Request $request)
    {
        return view('sales.index', [
            'module' => self::MODULE,
        ]);
    }

    public function ticket(Request $request)
    {
        $sale_id    = (int) $request->id;
        $sale       = Sale::find($sale_id);

        if (!$sale) {

            abort(404, 'Venta no encontrada');

        }

        $sale_date              = Carbon::createFromDate($sale->created_at)->format('d/m/Y H:i:s');
        $sale_code_ticket       = $sale->ticket;
        $sale_amount_iva        = $sale->amount_total * 0.16;
        $sale_amount_subtotal   = $sale->amount_total - $sale_amount_iva;
        $sale_amount_total      = $sale->amount_total;
        $sale_amount_payment    = $sale->amount_payment;
        $sale_amount_change     = $sale->amount_change;
        $sale_detail            = json_decode($sale->detail);
        $sale_items_ticket      = json_decode($sale->detail, true);
        $height_page            = (count($sale_items_ticket) * 20) + 424.46;

        // ********************************************************************* //
        // **! ->setPaper([0, 0, 283.46, 841.89], papel a 10 cm de ancho     !** //
        // **! ->setPaper([0, 0, 283.46, 841.89], alto tamaño carta          !** //
        // **! ->setPaper([0, 0, 283.46, $height_page], se calcula el alto   !** //
        // ********************************************************************* //

        $pdf = PDF::loadView('sales.ticket', compact(
                'sale_date',
                'sale_code_ticket',
                'sale_amount_iva',
                'sale_amount_subtotal',
                'sale_amount_total',
                'sale_amount_payment',
                'sale_amount_change',
                'sale_detail'
            ))
            ->setPaper([0, 0, 283.46, $height_page])
            ->setOption('margin-top', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0);

        return $pdf->download('ticket_de_venta.pdf');
    }
}
