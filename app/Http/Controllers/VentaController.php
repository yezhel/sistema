<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\ Carbon;
use app\Venta;
use app\DetalleVenta;
class VentaController extends Controller
{
    public function index( Request $request)
    {
        //Uso de elocuent
        if(!$request->ajax())
            return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == '')
        {
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante','ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total','ventas.estado','personas.nombre','users.usuario')
            ->orderBy('ventas.id', 'desc')->paginate(3);
        } 
        else
        {
            //Eloquent
             $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante','ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total','ventas.estado','personas.nombre','users.usuario')
            ->where('ventas.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('ventas.id','desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'             => $ventas->total(),
                'current_page'      => $ventas->currentPage(),
                'per_page'          => $ventas->perPage(),
                'last_page'         => $ventas->lastPage(),
                'from'              => $ventas->firstItem(),
                'to'                => $ventas->lastItem(),
            ],
            'ventas'            => $ventas
        ];
    }

    public function obtenerCabecera(Request $request)
    {
        //Uso de elocuent
        if(!$request->ajax())
            return redirect('/');

        $id = $request->id;
        $ingreso = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total','ingresos.estado','personas.nombre','users.usuario')
        ->where('ingresos.id','=',$id)
        ->orderBy('ingresos.id', 'desc')->take(1)->get();
        
        return ['ingreso' => $ingreso ];
    }

    public function obtenerDetalles(Request $request)
    {
       //Uso de elocuent
        if(!$request->ajax())
            return redirect('/');

        $id = $request->id;
        $detalles = DetalleIngreso::join('articulos','detalle_ingresos.idarticulo','=','articulos.id')
        ->select('detalle_ingresos.cantidad','detalle_ingresos.precio','articulos.nombre as articulo')
        ->where('detalle_ingresos.idingreso','=',$id)
        ->orderBy('detalle_ingresos.id', 'desc')->get();
        
        return ['detalles' => $detalles ]; 
    }
    //recibe por ajax
    public function store(Request $request)
    {
        if(!$request->ajax())
            return redirect('/');

        try
        {
        	//Uso de transacciones
        	DB::beginTransaction();
	        
	        $mytime = Carbon::now('America/Mexico_City');

	        $ingreso = new Ingreso();
	        $ingreso->idproveedor = $request->idproveedor;
	        $ingreso->idusuario = \Auth::user()->id;//id del usuario que esta autenticado
	        $ingreso->tipo_comprobante = $request->tipo_comprobante;
	        $ingreso->serie_comprobante = $request->serie_comprobante;
	        $ingreso->num_comprobante = $request->num_comprobante;
	        $ingreso->fecha_hora = $mytime->toDateString();
	        $ingreso->impuesto = $request->impuesto;
	        $ingreso->total = $request->total;
	        $ingreso->estado = 'Registrado';
	        $ingreso->save();

	    	$detalles = $request->data;//Array de detalles

	    	foreach($detalles as $ep => $det)
	    	{
	    		$detalle = new DetalleIngreso();
	    		$detalle->idingreso = $ingreso->id;
	    		$detalle->idarticulo = $det['idarticulo'];
	    		$detalle->cantidad = $det['cantidad'];
	    		$detalle->precio = $det['precio'];
	    		$detalle->save();
	    	}

	        DB::commit();


        }catch(Exception $e){
        	DB::rollBack();
        }
    }


    public function desactivar(Request $request)
    {
        if(!$request->ajax())
            return redirect('/');

        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save(); 
    }
}
