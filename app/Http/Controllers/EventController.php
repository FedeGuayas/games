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

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Vista para crear nuevo evento.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provincias = Provincia::all();
        $list_provincias = $provincias->pluck('province', 'id');

        $deportes = Deporte::where('status', Deporte::DEPORTE_ACTIVO)->get();
        $list_deportes = $deportes->pluck('name', 'id');

        $residencias = Residencia::where('status', Residencia::RESIDENCIA_ACTIVO)->get();
        $list_residencias = $residencias->pluck('name', 'id');

        return view('eventos.create', compact('list_provincias', 'list_deportes', 'list_residencias'));
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
     * Obtengo los atletas de una provincia y deporte determinado
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
     * Vista para generar comanda.
     *
     * @return \Illuminate\Http\Response
     */
    public function createComanda()
    {
        $provincias = Provincia::all();
        $list_provincias = $provincias->pluck('province', 'id');

        $deportes = Deporte::where('status', Deporte::DEPORTE_ACTIVO)->get();
        $list_deportes = $deportes->pluck('name', 'id');

        $residencias = Residencia::where('status', Residencia::RESIDENCIA_ACTIVO)->get();
        $list_residencias = $residencias->pluck('name', 'id');

        return view('comandas.create_comanda', compact('list_provincias', 'list_deportes', 'list_residencias'));
    }


    /**
     * Obtengo los atletas para la comanda
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listPersonasComandas(Request $request)
    {

        if ($request->ajax()) {

            $provincia_id = $request->input('provincia_id');
            $deporte_id = $request->input('deporte_id');
            $residencia_id = $request->input('residencia_id');
            $tipo = $request->input('tipo');
            $date = $request->input('date');

            $provincia = Provincia::where('id', $provincia_id)->first();
            $deporte = Deporte::where('id', $deporte_id)->first();
            $residencia = Residencia::where('id', $residencia_id)->first();


            $evento = Event::
            where('provincia_id', $provincia_id)
                ->where('deporte_id', $deporte_id)
                ->where('residencia_id', $residencia_id)
                ->where('tipo', $tipo)
                ->where([
                    ['date_start', '<=', $date],
                    ['date_end', '>=', $date],
                ])
//               ->whereBetween('creado', [DATE_FORMAT($start), DATE_FORMAT($end)]);
                ->first();

            if (isset($evento)){
                $lista = AthleteEvent::from('athlete_event as ae')
                    ->join('athletes as a', 'a.id', '=', 'ae.athlete_id')
                    ->where('ae.event_id', $evento->id)
                    ->select('a.id', 'a.name', 'a.last_name', 'a.document', 'a.gen', 'a.funcion')
                    ->get();
            }else {
                $lista=[];
            }

            return view('comandas.list', compact('lista','evento'));

        }

    }

}
