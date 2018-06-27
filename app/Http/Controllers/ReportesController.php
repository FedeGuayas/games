<?php

namespace App\Http\Controllers;

use App\AthleteEvent;
use App\Deporte;
use App\Event;
use App\Provincia;
use App\Residencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * imprimir comandas en pdf
     * @param $id
     * @return mixed
     */
    public function comandaPDF(Request $request)
    {

//        $date = $request->input('date');
//
//        if (!isset($date)){
//            return back()->with('message_danger','Debe seleccionar la fecha de impresión')->withInput();
//        }
//        $date = $request->input('date');

        $evento_id = $request->input('evento_id');

        $seleccionados = $request->input('seleccionar');
        $observaciones = $request->input('observaciones');
        $sustitutiva= $request->input('sustitutiva');

        $evento = Event::where('id', $evento_id)->first();
        $provincia = Provincia::where('id', $evento->provincia_id)->first();
        $deporte = Deporte::where('id', $evento->deporte_id)->first();
        $residencia = Residencia::where('id', $evento->residencia_id)->first();

        $tipo = $evento->tipo;
        if ($tipo == 'H') {
            $tipo = 'HOSPEDAJE';
            $periodo_de = 'HOSPEDAJE';
        } elseif ($tipo == 'A') {
            $tipo = 'ALMUERZO';
            $periodo_de = 'ALIMENTACIÓN';
        } elseif ($tipo == 'D'){
            $tipo = 'DESAYUNO';
            $periodo_de = 'ALIMENTACIÓN';
        }elseif ($tipo=='M'){
            $tipo='MERIENDA';
            $periodo_de = 'ALIMENTACIÓN';
        }

        //lista de atletas incluidos en el evento y seleccionados en la lista de comanda
        $lista = AthleteEvent::from('athlete_event as ae')
            ->join('athletes as a', 'a.id', '=', 'ae.athlete_id')
            ->where('ae.event_id', $evento->id)
            ->whereIn('a.id', $seleccionados)
            ->select('a.id', 'a.name', 'a.last_name', 'a.document', 'a.gen', 'a.funcion')
            ->orderBy('a.last_name')
            ->get();

        $dia_inicio=Carbon::parse($evento->date_start);
        $dia_fin=Carbon::parse($evento->date_end);

        $cantidad_dias=$dia_fin->diffInDays($dia_inicio)+1; //25 al 29 = 5 dias

        $diasArray=[];
        for($i=0; $i<$cantidad_dias; ++$i){
            $diasArray[] = $dia_inicio->copy()->addDays($i);
        }

        $impresiones=count($diasArray);

        if (count($lista)>0 && $impresiones>0) {
            set_time_limit(0);
            ini_set('memory_limit', '1G');


            if (isset($sustitutiva) && $sustitutiva=='true' ){

                $pdf = PDF::loadView('reportes.comandas-sust-pdf', compact('lista', 'impresiones','diasArray','tipo','evento','provincia','deporte','residencia','pdf','periodo_de','observaciones'));
            }else{
                $pdf = PDF::loadView('reportes.comandas-pdf', compact('lista', 'impresiones','diasArray','tipo','evento','provincia','deporte','residencia','pdf','periodo_de'));
            }





//            try {
//                $pdf->save(storage_path('Comanda.pdf'));
//            }catch (\Exception $e){
//
//            }
//            return response()->download(storage_path('Comanda.pdf'));


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
