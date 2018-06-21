<?php

namespace App\Http\Controllers;

use App\AthleteEvent;
use App\Deporte;
use App\Event;
use App\Provincia;
use App\Residencia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReportesController extends Controller
{
    /**
     * imprimir comandas en pdf
     * @param $id
     * @return mixed
     */
    public function comandaPDF(Request $request)
    {

        $provincia_id = $request->input('provincia_id');
        $deporte_id = $request->input('deporte_id');
        $residencia_id = $request->input('residencia_id');
        $tipo = $request->input('tipo');
        $date = $request->input('date');
        $evento_id = $request->input('evento_id');

        $seleccionados = $request->input('seleccionar');

        $provincia = Provincia::where('id', $provincia_id)->first();
        $deporte = Deporte::where('id', $deporte_id)->first();
        $residencia = Residencia::where('id', $residencia_id)->first();
        $evento = Event::where('id', $evento_id)->first();

        if ($tipo == 'H') {
            $tipo = 'HOSPEDAJE';
        } elseif ($tipo == 'A') {
            $tipo = 'ALMUERZO';
        } elseif ($tipo == 'D'){
            $tipo = 'DESAYUNO';
        }elseif ($tipo=='M'){
            $tipo='MERIENDA';
        }


        if (isset($evento)){
            $lista = AthleteEvent::from('athlete_event as ae')
                ->join('athletes as a', 'a.id', '=', 'ae.athlete_id')
                ->where('ae.event_id', $evento->id)
                ->whereIn('a.id', $seleccionados)
                ->select('a.id', 'a.name', 'a.last_name', 'a.document', 'a.gen', 'a.funcion')
                ->get();
        }else {
            $lista=[];
        }

        if (count($lista)>0) {

            set_time_limit(0);
            ini_set('memory_limit', '1G');
            $pdf = PDF::loadView('reportes.comandas-pdf', compact('lista', 'date','tipo','evento','provincia','deporte','residencia','pdf'));

            return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->stream('Comanda');//imprime en pantalla
        } else {
            return redirect()->back()->with('message_danger', 'Seleccione las personas que desea incluir en la comanda');
        }


//            PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')
//        $pdf = PDF::loadView('reportes.reforma-pdf', compact('reforma', 'detalles_o', 'detalles_d', 'jefe_area'));
//                return $pdf->download('Refroma.pdf');//descarga el pdf
//        return $pdf->setPaper('letter', 'landscape')->stream('Reforma');//imprime en pantalla

    }
}
