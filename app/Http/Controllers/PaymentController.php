<?php

namespace App\Http\Controllers;


use App\Pago;
use App\User;
use App\Notifications\NotificationPay;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        
        $pagos = Pago::orWhere('pagos.venta_id','like',"%$busqueda%")
        ->orWhere('pagos.estado','like',"%$busqueda%")
        ->orWhere('pagos.id', $busqueda)
        ->orWhere('pagos.monto', $busqueda)
        ->orderBy('pagos.fecha', 'DESC')
        ->paginate(5);

        return view('admin.pagos.index', compact('pagos'));
    }

    public function response()
    {
        return view('epayco.response');
    }

    public function store($x_ref_payco, $total, $venta_id, $x_cod_response)
    {
        $pago = new Pago();
        $pago->ref_epayco = $x_ref_payco;
        $pago->fecha = \Carbon\Carbon::now();
        $pago->monto = $total;
        $pago->venta_id = $venta_id;
        $pago->estado =  $x_cod_response;

        $pago->save();//guardar el pago

    }

    public function printPay(Request $request, $id)
    {
        $pagos = Pago::where('pagos.id', $id)
        ->orderBy('pagos.fecha', 'DESC')
        ->get();

        $pdf = \PDF::loadView('admin.pdf.pago',['pagos'=>$pagos])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('pago-'.$pagos[0]->id.'.pdf');
    }

    public function pdfPagosReporte()
    {
        $pagos = Pago::orderBy('pagos.fecha')
        ->get();

        $count = 0;
        foreach ($pagos as $pago) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.listadopagos',['pagos'=>$pagos, 'count'=>$count])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('listadopagos.pdf');
    }
}
