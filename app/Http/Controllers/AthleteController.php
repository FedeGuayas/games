<?php

namespace App\Http\Controllers;

use App\Athlete;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Datatables;
use Barryvdh\DomPDF\Facade as PDF;
use Codedge\Fpdf\Fpdf\Fpdf;

//include_once('../../PDF.php');

class AthleteController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('athletes.index');
    }


    /**
     * Obtener todos los atltetas para datatables
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllAthletes(Request $request)
    {


        if ($request->ajax()) {

            $atletas = Athlete::query();

            $action_buttons = '
                <a href="{{ route(\'athletes.edit\',[$id] ) }}" style="text-decoration-line: none">
                    <button class="btn-xs btn-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                </a>
                 {!! Form::button(\'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>\',[\'class\'=>\'btn-xs btn-danger\',\'value\'=>$id,\'onclick\'=>\'eliminar(this)\']) !!}
               
                ';

            //{!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-[$id]"]) !!}
            return Datatables::eloquent($atletas)
                ->addColumn('actions', $action_buttons)
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('athletes.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('athletes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        try {

            DB::beginTransaction();

            $atleta = new Athlete();
            $atleta->name = strtoupper($request->input('name'));
            $atleta->last_name = strtoupper($request->input('last_name'));
            $atleta->document = strtoupper($request->input('document'));
            $atleta->sport = strtoupper($request->input('sport'));
            $atleta->provincia = strtoupper($request->input('provincia'));
            $atleta->funcion = strtoupper($request->input('funcion'));

            $atleta->gen = strtoupper($request->input('gen'));
            $atleta->birth_date = strtoupper($request->input('birth_date'));
            $atleta->event = strtoupper($request->input('event'));
            $atleta->date_ins = strtoupper($request->input('date_ins'));
            $atleta->procedencia = strtoupper($request->input('procedencia'));
            $atleta->provincia = strtoupper($request->input('provincia'));
            $atleta->notes = strtoupper($request->input('notes'));
            $atleta->place = strtoupper($request->input('place'));


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $request->input('document') . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/uploads/athletes/img';
                $file->move($path, $name);
                $atleta->image = $name;
            }

            $atleta->save();

            DB::commit();


        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back('');
        }

        return redirect()->route('athletes.index');

    }


    /**
     * @param Athlete $athlete
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $athlete = Athlete::query()->findOrFail($id);

        return view('athletes.edit', compact('athlete'));
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


            $atleta = Athlete::query()->findOrFail($id);

            $atleta->name = strtoupper($request->input('name'));
            $atleta->last_name = strtoupper($request->input('last_name'));
            $atleta->document = strtoupper($request->input('document'));
            $atleta->sport = strtoupper($request->input('sport'));
            $atleta->provincia = strtoupper($request->input('provincia'));
            $atleta->funcion = strtoupper($request->input('funcion'));

            $atleta->gen = strtoupper($request->input('gen'));
            $atleta->birth_date = strtoupper($request->input('birth_date'));
            $atleta->event = strtoupper($request->input('event'));
            $atleta->date_ins = strtoupper($request->input('date_ins'));
            $atleta->procedencia = strtoupper($request->input('procedencia'));
            $atleta->provincia = strtoupper($request->input('provincia'));
            $atleta->notes = strtoupper($request->input('notes'));
            $atleta->place = strtoupper($request->input('place'));

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $request->input('document') . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/uploads/athletes/img';
                $file->move($path, $name);
                $atleta->image = $name;
            }

            $atleta->save();

            DB::commit();


        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back('');
        }

        return redirect()->route('athletes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {

            try {

                DB::beginTransaction();

                $atleta = Athlete::query()->findOrFail($id);
                $file = $atleta->image;
                $filename = public_path() . '/uploads/athletes/img/' . $file;
                \File::delete($filename);
                $atleta->delete();

                DB::commit();

            } catch (\Exception $e) {

                DB::rollback();
                return response()->json(['rep' => 'Ocurrio un error, no se pudo eliminar el registro']);
            }
            return response()->json(['resp' => 'Atleta Eliminado!']);
        }
        return redirect()->route('athletes.index');

    }


    /**
     * Importar atletas excell
     *
     * @param Request $request
     */
    public function importAthletes(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();


            //LLenar tabla atletas
            $insert = [];
            if (!empty($data) && $data->count()) {
                try {
                    DB::beginTransaction();

                    foreach ($data as $key => $value) {
                        
                        $doc = $value->doc_de_ident;
//                        $subcadena = ".0";
//                        $posicionsubcadena = strpos ($cadena, $subcadena);
//                        $doc = substr ($cadena, ($posicionsubcadena+1));

                        $insert[] = [
                                "codigo" => $value->codigo,
                                "event"=>$value->evento,
                                "place"=>$value->lugar,
                                "date_ins"=>$value->fecha_de_inscripcion,
                                "procedencia"=>$value->participa_por,
                                "sport"=>$value->deporte,
                                "document"=>$doc,
                                "last_name"=>$value->apellidos,
                                "name"=>$value->nombres,
                                "gen"=>$value->genero,
                                "birth_date"=>$value->fecha_de_nacimiento,
                                "federator_num"=>$value->no_fedenador_ecuador,
                                "notes"=>$value->observaciones,
                                "provincia"=>$value->provincia,
                                "funcion"=>$value->funcion,
                                "image"=>$doc.'.'.'jpg'
//                               "image" => str_replace(',', '.', $value->doc_de_ident),
                            ];


                    }
                    if (!empty($insert)) {
                        foreach (array_chunk($insert,1000) as $data) {

                            DB::table('athletes')->insert($data);

                        }


                    }

                    DB::commit();
                    return redirect()->back()->with(["message"=>"Registros cargados"]);

                } catch (\Exception $e) {
                    DB::rollback();

//                    return redirect()->back()->with(["message_danger" => "Ah ocurrido un error al cargar el archivo"]);
                    return redirect()->back()->with(["message_danger" => 'Error' . $e->getMessage()]);
                }
            }
        }

    }

    /**
     *
     * Exportar Credenciales de Atletas para imprimirlas
     * @param Request $request
     * @param FPDF $fpdf
     * @return \Illuminate\Http\RedirectResponse
     */
    public function exportCredenciales(Request $request)
    {
        $imp_cred = $request->get('imp_cred');

        if (!is_null($imp_cred)) {
//            if (count($imp_cred) > 8) {
//                return redirect()->back()->with('message_danger', 'No seleccionar mas de 8 inscripciones por pagina a imprimir');
//            }
//              else {

            $credenciales = Athlete::query()->whereIn('id', $imp_cred)->get();
$posicion=0;

            set_time_limit(0);
            ini_set('memory_limit', '1G');

            $pdf = PDF::loadView('reportes.credenciales-pdf', compact('credenciales','posicion'));
            return $pdf->stream('Credenciales');//imprime en pantalla
        } else {
            return redirect()->back()->with('message_danger', 'Seleccione los atletas  que desees imprimir sus credenciales');
        }

    }

    /**
     * Imprimir
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printAthletes()
    {
        return view('athletes.print');
    }


    /**
     * Obtener todos los atltetas para datatables
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCredencials(Request $request)
    {


        if ($request->ajax()) {

            $atletas = Athlete::query();

            $action_buttons = '
                 
                <a href="!#">
                {!! Form::checkbox(\'imp_cred[]\',$id,false,[\'id\'=>$id]) !!}
                </a>
               
                ';

            //{!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-[$id]"]) !!}
            return Datatables::eloquent($atletas)
                ->addColumn('actions', $action_buttons)
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('athletes.print');
    }
}
