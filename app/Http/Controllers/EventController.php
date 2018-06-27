<?php

namespace App\Http\Controllers;

use App\Athlete;
use App\AthleteEvent;
use App\Deporte;
use App\Event;
use App\Provincia;
use App\Residencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista con la lista de participantes
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('eventos.index');
    }


    /**
     * Obtener todos los eventos para datatables
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllEvents(Request $request)
    {
        if ($request->ajax()) {

            if ($request->user()->hasRole('admin')){
                $eventos = Event::from('events as e')
                    ->join('deportes as d', 'd.id', '=', 'e.deporte_id')
                    ->join('provincias as p', 'p.id', '=', 'e.provincia_id')
                    ->join('residencias as r', 'r.id', '=', 'e.residencia_id')
                    ->where('e.status', '=', Event::EVENTO_ACTIVO)
                    ->select('e.*', 'd.name as deporte', 'p.province', 'r.name as residencia');
            }

            if ($request->user()->hasRole('usuario')){
                $eventos = Event::from('events as e')
                    ->join('deportes as d', 'd.id', '=', 'e.deporte_id')
                    ->join('provincias as p', 'p.id', '=', 'e.provincia_id')
                    ->join('residencias as r', 'r.id', '=', 'e.residencia_id')
                    ->where('e.status', '=', Event::EVENTO_ACTIVO)
                    ->where('r.name', '=', 'CEAR')
                    ->select('e.*', 'd.name as deporte', 'p.province', 'r.name as residencia');
            }


            $action_buttons = '
                <a href="{{ route(\'events.edit\',[$id] ) }}" style="text-decoration-line: none">
                    <button class="btn-xs btn-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                </a>
                ';
//            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',['class'=>'btn-xs btn-danger','value'=>$id,'onclick'=>'eliminar(this)']) !!}

            //{!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-[$id]"]) !!}
            return Datatables::eloquent($eventos)
                ->addColumn('actions', $action_buttons)
                ->addColumn('deportes', function ($eventos) {
                    return $eventos->deporte;
                })
                ->filterColumn('deportes', function ($query, $keyword) {
                    $query->whereRaw("d.name like ?", ["%{$keyword}%"]);
                })
                ->addColumn('provincia', function ($eventos) {
                    return $eventos->province;
                })
                ->filterColumn('provincia', function ($query, $keyword) {
                    $query->whereRaw("province like ?", ["%{$keyword}%"]);
                })
                ->addColumn('residencia', function ($eventos) {
                    return $eventos->residencia;
                })
                ->filterColumn('residencia', function ($query, $keyword) {
                    $query->whereRaw("r.name like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('date_start', function ($query, $keyword) {
                    $query->whereRaw("e.date_start like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('date_end', function ($query, $keyword) {
                    $query->whereRaw("e.date_end like ?", ["%{$keyword}%"]);
                })
                ->editColumn('tipo', function ($eventos) {
                    if  ($eventos->tipo=='H'){
                       return 'HOSPEDAJE';
                   }elseif ($eventos->tipo=='A'){
                       return 'ALMUERZO';
                  }elseif ($eventos->tipo=='D'){
                      return 'DESAYUNO';
                  }elseif ($eventos->tipo=='M'){
                      return 'MERIENDA';
                  }
                })
                ->filterColumn('tipo', function ($query, $keyword) {
                    $query->whereRaw("e.tipo like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('eventos.index');
    }


    /**
     * Vista para crear nuevo evento.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $provincias = Athlete::from('athletes as a')
            ->join('provincias as p', 'p.id', '=', 'a.provincia_id')
            ->select('p.id', 'p.province')
            ->orderBy('p.province')
            ->distinct()
            ->get();
        $list_provincias = $provincias->pluck('province', 'id');

        $deportes = Deporte::where('status', Deporte::DEPORTE_ACTIVO)->get();
        $list_deportes = $deportes->pluck('name', 'id');


        if ($request->user()->hasRole('admin')){
            $residencias = Residencia::where('status', Residencia::RESIDENCIA_ACTIVO)->get();
        }
        if ($request->user()->hasRole('usuario')){
            $residencias = Residencia::
                where('name','CEAR')
                ->where('status', Residencia::RESIDENCIA_ACTIVO)
                ->get();
        }

        $list_residencias = $residencias->pluck('name', 'id');


        return view('eventos.create', compact('list_provincias', 'list_deportes', 'list_residencias'));
    }


    /**
     * Obtener los deportes para una provincia para crear evento select dinamico
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeportesProvincia(Request $request)
    {
        if ($request->ajax()) {

            $provincia_id = $request->input('provincia_id');

            $deportes = Athlete::from('athletes as a')
                ->join('deportes as d', 'd.id', '=', 'a.deporte_id')
                ->where('d.status', '=', Deporte::DEPORTE_ACTIVO)
                ->where('a.provincia_id', $provincia_id)
                ->select('d.id', 'd.name')
                ->distinct()
                ->get();

            return response()->json($deportes);
        }
    }


    /**
     * Obtengo la cantidad de atletas de una provincia y deporte determinado
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countAtletas(Request $request)
    {
        if ($request->ajax()) {

            $provincia_id = $request->input('provincia_id');
            $deporte_id = $request->input('deporte_id');

            $provincia = Provincia::where('id', $provincia_id)->first();
            $deporte = Deporte::where('id', $deporte_id)->first();

            $atletas = Athlete::
            //que no esten inactivos
            where('status', '!=', Athlete::ATLETA_INACTIVO)
                //pertenecen a la provincia seleccionada
                ->where('provincia_id', $provincia->id)
                //al deporte seleccionado
                ->where('deporte_id', $deporte->id)
                //solo deportistas o entrenadores
                ->where(function ($query) {
                    $query->where('funcion', 'like', '%deportista%')
                        ->orwhere('funcion', 'like', '%entrenador%');
                })
                ->count();
            return response()->json($atletas);
        }

    }

    /**
     * Obtengo listados de personas que seran agregadas al evento, solo deportistas y entrenadores de una provincia y deporte determinado
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadAtletas(Request $request)
    {

        if ($request->ajax()) {

            $provincia_id = $request->input('provincia_id');
            $deporte_id = $request->input('deporte_id');

            $provincia = Provincia::where('id', $provincia_id)->first();
            $deporte = Deporte::where('id', $deporte_id)->first();

            $list_atletas = Athlete::
                //que no esten inactivos
                where('status', '!=', Athlete::ATLETA_INACTIVO)
                //pertenecen a la provincia seleccionada
                ->where('provincia_id', $provincia->id)
                //al deporte seleccionado
                ->where('deporte_id', $deporte->id)
                //solo deportistas o entrenadores
                ->where(function ($query) {
                    $query->where('funcion', 'like', '%deportista%')
                        ->orwhere('funcion', 'like', '%entrenador%');
                })
                ->get();

            return view('eventos.listPersonas', compact('list_atletas'));

        }

    }


    /**
     * Guardar el evento y los datos de las personas asignadas al mismo
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $evento = new Event();
            $evento->deporte_id = $request->input('deporte_id');
            $evento->provincia_id = $request->input('provincia_id');
            $evento->residencia_id = $request->input('residencia_id');
            $evento->tipo = $request->input('tipo');
            $evento->date_start = $request->input('date_start');
            $evento->date_end = $request->input('date_end');
            $evento->notes = strtoupper($request->input('notes'));
            $evento->save();

            $seleccionados = $request->input('seleccionar');

            if (count($seleccionados) > 0) {
                $cont = 0;
                while ($cont < count($seleccionados)) {
                    $atleta_evento = new AthleteEvent();
                    $atleta_evento->athlete_id = $seleccionados[$cont];
                    $atleta_evento->event_id = $evento->id;
                    $cont++;
                    $atleta_evento->save();
                }
            } else {
                return redirect()->back()->with('message_danger', 'No seleccionó los participantes que desea agregar al evento');
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('message_danger', 'Ha ocurrido un error al crear el registro');
//            return redirect()->back()->with('message_danger',$e->getMessage());
        }

        return redirect()->back()->with('message', 'Evento credado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $event = Event::where('id', $id)->first();

        //lista de personas del deporte y provincia en el evento
        $lista = AthleteEvent::from('athlete_event as ae')
            ->join('athletes as a', 'a.id', '=', 'ae.athlete_id')
            ->where('ae.event_id',$event->id )
            ->select('a.id', 'a.name', 'a.last_name', 'a.document', 'a.gen', 'a.funcion', 'a.acreditado')
            ->orderBy('a.last_name')
            ->get();

        $incluidos = [];
        foreach ($lista as $l) {
            $incluidos[] = $l->id;
        }

        $incluidos_id = $incluidos;

        //lista de todas las personas activas del deporte y la provincia que no estan en e le evento
        $listaAll = Athlete::from('athletes as a')
            ->where('a.status', Athlete::ATLETA_ACTIVO)
            ->where('a.provincia_id', $event->provincia_id)
            ->where('a.deporte_id', $event->deporte_id)
            ->whereNotIn('id', $incluidos_id)
            ->select('a.id', 'a.name', 'a.last_name', 'a.document', 'a.gen', 'a.funcion', 'a.acreditado')
            ->orderBy('a.last_name')
            ->get();

        $provincias = Provincia::all();
        $list_provincias = $provincias->pluck('province', 'id');

        $deportes = Deporte::where('status', Deporte::DEPORTE_ACTIVO)->get();
        $list_deportes = $deportes->pluck('name', 'id');

        if ($request->user()->hasRole('admin')){
            $residencias = Residencia::where('status', Residencia::RESIDENCIA_ACTIVO)->get();
        }
        if ($request->user()->hasRole('usuario')){
            $residencias = Residencia::
            where('name','CEAR')
                ->where('status', Residencia::RESIDENCIA_ACTIVO)
                ->get();
        }

        $list_residencias = $residencias->pluck('name', 'id');

        return view('eventos.edit', compact('list_provincias', 'list_deportes', 'list_residencias', 'event', 'lista', 'listaAll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $residencia_id = $request->input('residencia_id');
            $tipo = $request->input('tipo');
            $date_start = $request->input('date_start');
            $date_end = $request->input('date_end');
            $notes = $request->input('notes');

            $evento = Event::where('id', $id)->first();

            $seleccionar_quitar = $request->input('seleccionar_quitar'); //personas seleccionadas para eliminar del evento
            $seleccionar_agregar = $request->input('seleccionar_agregar'); //personas seleccionadas para agregar al evento

            if (isset($seleccionar_agregar)) {

                if (count($seleccionar_agregar) > 0) {
                    $cont = 0;
                    while ($cont < count($seleccionar_agregar)) {
                        $atleta_evento = new AthleteEvent();
                        $atleta_evento->athlete_id = $seleccionar_agregar[$cont];
                        $atleta_evento->event_id = $evento->id;
                        $cont++;
                        $atleta_evento->save();
                    }
                }
            }

            if (isset($seleccionar_quitar)) {

                if (count($seleccionar_quitar) > 0) {
                    $cont = 0;
                    while ($cont < count($seleccionar_quitar)) {
                        $atleta_evento = AthleteEvent::where('event_id', $evento->id)->where('athlete_id', $seleccionar_quitar[$cont])->first();
                        $cont++;
                        $atleta_evento->delete();
                    }
                }
            }

            $evento->residencia_id = $residencia_id;
            $evento->tipo = $tipo;
            $evento->date_start = $date_start;
            $evento->date_end = $date_end;
            $evento->notes = $notes;


            $evento->update();

            DB::commit();


            return redirect()->back()->with('message', 'Evento actualizado');

        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('message_danger', 'Ha ocurrido un error al actualizar los cambios')->withInput();
//            return redirect()->back()->with('message_danger',$e->getMessage())->withInput();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }


    /**
     * Vista para generar comanda.
     *
     * @return \Illuminate\Http\Response
     */
    public function createComanda()
    {
        $provincias = Event::from('events as e')
            ->join('provincias as p', 'p.id', '=', 'e.provincia_id')
            ->select('p.province', 'p.id')
            ->get();
        $list_provincias = $provincias->pluck('province', 'id');

        return view('comandas.create_comanda', compact('list_provincias'));
    }


    /**
     * Obtengo los atletas para la comanda
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listPersonasComandas($id, $status)
    {
//        $date = $request->input('date');

        $evento = Event::where('id', $id)
//            ->where([
//                ['date_start', '<=', $date],
//                ['date_end', '>=', $date],
//            ])
            ->first();

        if (isset($evento)) {

            switch ($status) {
                case Athlete::ATLETA_ACREDITADO: //'1'
                    $lista = AthleteEvent::from('athlete_event as ae')
                        ->join('athletes as a', 'a.id', '=', 'ae.athlete_id')
                        ->where('ae.event_id', $evento->id)
                        ->where('a.acreditado', $status)//acreditado
                        ->where('a.status', Athlete::ATLETA_ACTIVO)
                        ->select('a.id', 'a.name', 'a.last_name', 'a.document', 'a.gen', 'a.funcion', 'a.acreditado')
                        ->orderBy('a.last_name')
                        ->get();
                    break;
                case Athlete::ATLETA_ACTIVO: //'A'
                    $lista = AthleteEvent::from('athlete_event as ae')
                        ->join('athletes as a', 'a.id', '=', 'ae.athlete_id')
                        ->where('ae.event_id', $evento->id)
                        ->where('a.status', $status)//activo
                        ->select('a.id', 'a.name', 'a.last_name', 'a.document', 'a.gen', 'a.funcion', 'a.status')
                        ->orderBy('a.last_name')
                        ->get();
                    break;
            }

        }

//            $provincia_id = $request->input('provincia_id');
//            $deporte_id = $request->input('deporte_id');
//            $residencia_id = $request->input('residencia_id');
//            $tipo = $request->input('tipo');
//            $date = $request->input('date');

//            $provincia = Provincia::where('id', $provincia_id)->first();
//            $deporte = Deporte::where('id', $deporte_id)->first();
//            $residencia = Residencia::where('id', $residencia_id)->first();

        return view('comandas.list', compact('lista', 'evento'));


    }


    /**
     * Obtener los deportes para una provincia en el evento select dinamico
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeportes(Request $request)
    {
        if ($request->ajax()) {

            $provincia_id = $request->input('provincia_id');

            $deportes = Event::from('events as e')
                ->join('deportes as d', 'd.id', '=', 'e.deporte_id')
                ->where('provincia_id', $provincia_id)
                ->select('d.id', 'd.name')
                ->distinct()
                ->get();
            return response()->json($deportes);
        }
    }

    /**
     * Obtener las residencias para una provincia y deporte en el evento select dinamico
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResidencia(Request $request)
    {
        if ($request->ajax()) {

            $provincia_id = $request->input('provincia_id');
            $deporte_id = $request->input('deporte_id');

            $residencias = Event::from('events as e')
                ->join('residencias as r', 'r.id', '=', 'e.residencia_id')
                ->where('e.provincia_id', $provincia_id)
                ->where('e.deporte_id', $deporte_id)
                ->select('r.id', 'r.name')
                ->distinct()
                ->get();;
            return response()->json($residencias);
        }

    }

    /**
     * Obtengo los eventos para la comandas
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventos(Request $request)
    {

        if ($request->ajax()) {

            $provincia_id = $request->input('provincia_id');
            $deporte_id = $request->input('deporte_id');
            $residencia_id = $request->input('residencia_id');
            $status = $request->input('status');

            $evento = Event::from('events as e')
                ->join('provincias as p', 'p.id', '=', 'e.provincia_id')
                ->join('deportes as d', 'd.id', '=', 'e.deporte_id')
                ->join('residencias as r', 'r.id', '=', 'e.residencia_id')
                ->where('provincia_id', $provincia_id)
                ->where('deporte_id', $deporte_id)
                ->where('residencia_id', $residencia_id)
                ->where('e.status', Event::EVENTO_ACTIVO)
                ->select('e.id', 'p.province', 'd.name as deporte', 'r.name as residencia', 'e.date_start', 'e.date_end', 'e.tipo')
                ->get();

        }
        return view('eventos.list', compact('evento', 'status'));

    }

}
