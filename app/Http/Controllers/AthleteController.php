<?php

namespace App\Http\Controllers;

use App\Athlete;
use App\Deporte;
use App\Provincia;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Datatables;
use Barryvdh\DomPDF\Facade as PDF;
use Codedge\Fpdf\Fpdf\Fpdf;


class AthleteController extends Controller
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

            $atletas = Athlete::with('provincia', 'deporte')
                ->where('athletes.status', '!=', Athlete::ATLETA_INACTIVO)
                ->select('athletes.*');

            $action_buttons = '
                <a href="{{ route(\'athletes.edit\',[$id] ) }}" style="text-decoration-line: none">
                    <button class="btn-xs btn-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                </a>
                 {!! Form::button(\'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>\',[\'class\'=>\'btn-xs btn-danger\',\'value\'=>$id,\'onclick\'=>\'eliminar(this)\']) !!}
               
                ';

            //{!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-[$id]"]) !!}
            return Datatables::eloquent($atletas)
                ->addColumn('actions', $action_buttons)
                ->addColumn('provincia', function (Athlete $atleta) {
                    return $atleta->provincia->province;
                })
                ->filterColumn('provincia', function ($query, $keyword) {
                    $query->whereRaw("provincias.province like ?", ["%{$keyword}%"]);
                })
                ->addColumn('deporte', function (Athlete $atleta) {
                    if (isset($atleta->deporte)) {
                        return $atleta->deporte->name;
                    } else return false;
                })
                ->filterColumn('deporte', function ($query, $keyword) {
                    $query->whereRaw("deportes.name like ?", ["%{$keyword}%"]);
                })
                ->editColumn('acreditado', function ($atletas) {
                    if ($atletas->acreditado == Athlete::ATLETA_ACREDITADO) {
//                        return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                        return "SI";
                    } elseif ($atletas->acreditado == Athlete::ATLETA_NO_ACREDITADO) {
//                        return "<span class=\"text-success\">NO</span>";
                        return "NO";
                    }
                })
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
        $provincias = Provincia::all();
        $list_provincias = $provincias->pluck('province', 'id');

        $deportes = Deporte::where('status', Deporte::DEPORTE_ACTIVO)->get();
        $list_deportes = $deportes->pluck('name', 'id');
        return view('athletes.create', compact('list_provincias', 'list_deportes'));
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
            $provincia_id = $request->input('provincia_id');
            $provincia = Provincia::where('id', $provincia_id)->first();
            $atleta->funcion = strtoupper($request->input('funcion'));
            $atleta->status = strtoupper($request->input('status'));
            $deporte_id = $request->input('deporte_id');
            $deporte = Deporte::where('id', $deporte_id)->first();
            $atleta->gen = strtoupper($request->input('gen'));
            $atleta->birth_date = strtoupper($request->input('birth_date'));
            $atleta->notes = strtoupper($request->input('notes'));
            $atleta->deporte()->associate($deporte);
            $atleta->provincia()->associate($provincia);
            $acreditar = $request->input('acreditar');
            if ($acreditar == 'on') {
                $atleta->acreditado = Athlete::ATLETA_ACREDITADO;
            } else {
                $atleta->acreditado = Athlete::ATLETA_NO_ACREDITADO;
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $request->input('document') . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/uploads/athletes/img';
                $file->move($path, $name);
                $atleta->image = $name;
            }else {
                $atleta->image=$request->input('document');
            }

            $atleta->save();

            DB::commit();


        } catch (\Exception $e) {

            DB::rollback();
//            return redirect()->back()->with('message_danger', 'Ha ocurrido un error al crear el registro');
            return redirect()->back()->with('message_danger',$e->getMessage());
        }

        return redirect()->route('athletes.index')->with('message', 'Participante creado correctamente');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $athlete = Athlete::where('id', $id)->first();

        $provincias = Provincia::all();
        $list_provincias = $provincias->pluck('province', 'id');

        $deportes = Deporte::where('status', Deporte::DEPORTE_ACTIVO)->get();
        $list_deportes = $deportes->pluck('name', 'id');

        return view('athletes.edit', compact('athlete', 'list_provincias', 'list_deportes'));
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

            $fecha_nac=$request->input('birth_date');

            $atleta->name = strtoupper($request->input('name'));
            $atleta->last_name = strtoupper($request->input('last_name'));
            $atleta->document = strtoupper($request->input('document'));
            $provincia_id = $request->input('provincia_id');
            $provincia = Provincia::where('id', $provincia_id)->first();
            $atleta->funcion = strtoupper($request->input('funcion'));
            $atleta->status = strtoupper($request->input('status'));
            $deporte_id = $request->input('deporte_id');
            $deporte = Deporte::where('id', $deporte_id)->first();
            $atleta->gen = strtoupper($request->input('gen'));

            if( isset($fecha_nac)) {
                $atleta->birth_date = $fecha_nac;
            }else {
                $atleta->birth_date = null;
            }

            $atleta->notes = strtoupper($request->input('notes'));
            $atleta->deporte()->associate($deporte);
            $atleta->provincia()->associate($provincia);
            $acreditar = $request->input('acreditar');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $request->input('document') . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/uploads/athletes/img';
                $file->move($path, $name);
                $atleta->image = $name;
            }

            if ($acreditar == 'on') {
                $atleta->acreditado = Athlete::ATLETA_ACREDITADO;
            } else {
                $atleta->acreditado = Athlete::ATLETA_NO_ACREDITADO;
            }

            $atleta->update();

            DB::commit();


        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('message_danger', 'Ha ocurrido un error al actualizar el participante');
//            return redirect()->back()->with('message_danger', $e->getMessage());
        }

        return redirect()->route('athletes.index')->with('message', 'Registro actualizado correctamente');
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

                $atleta = Athlete::where('id', $id)->first();
//                $file = $atleta->image;
//                $filename = public_path() . '/uploads/athletes/img/' . $file;
//                \File::delete($filename);
                $atleta->status = Athlete::ATLETA_INACTIVO;
                $atleta->update();

                DB::commit();

            } catch (\Exception $e) {

                DB::rollback();
                return response()->json(['rep' => 'Ocurrio un error, no se pudo realizar la acción']);
            }
            return response()->json(['resp' => 'Atleta inactivo!']);
        }
        return redirect()->route('athletes.index');

    }

    public function getImport()
    {
        return view('athletes.import');
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
                            "deporte_id" => $value->deporte,
                            "document" => $doc,
                            "last_name" => $value->apellidos,
                            "name" => $value->nombres,
                            "gen" => $value->genero,
                            "status"=>$value->status,
                            "provincia_id" => $value->provincia,
                            "funcion" => $value->funcion,
                            "image" => $doc . '.' . 'jpg'
//                               "image" => str_replace(',', '.', $value->doc_de_ident),
                        ];

                    }
                    if (!empty($insert)) {
                        foreach (array_chunk($insert, 1000) as $data) {
                            DB::table('athletes')->insert($data);
                        }
                    }

                    DB::commit();
                    return redirect()->route('getAllAthletes')->with(["message" => "Registros importados"]);

                } catch (\Exception $e) {
                    DB::rollback();

//                    return redirect()->back()->with(["message_danger" => "Ah ocurrido un error al cargar el archivo"]);
                    return redirect()->back()->with(["message_danger" => 'Error' . $e->getMessage()]);
                }
            }
        }

    }

    /**
     * Vista de imprimir credenciales
     *
     * @return \Illuminate\Http\Response
     */
    public function printAthletes()
    {
        return view('athletes.print');
    }

    /**
     * Obtener todos los atltetas para datatables para la impresion de credenciales
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCredencials(Request $request)
    {
        if ($request->ajax()) {


            $atletas = Athlete::with('provincia', 'deporte')
                ->where('athletes.status', '!=', Athlete::ATLETA_INACTIVO)
                ->select('athletes.*');

            $action_buttons = '
                 
                <a href="#">
                {!! Form::checkbox(\'imp_cred[]\',$id,false,[\'id\'=>$id]) !!}
                </a>
               
                ';

            return Datatables::eloquent($atletas)
                ->addColumn('actions', $action_buttons)
                ->addColumn('provincia', function (Athlete $atleta) {
                    return $atleta->provincia->province;
                })
                ->filterColumn('provincia', function ($query, $keyword) {
                    $query->whereRaw("provincias.province like ?", ["%{$keyword}%"]);
                })
                ->addColumn('deporte', function (Athlete $atleta) {
                    if (isset($atleta->deporte)) {
                        return $atleta->deporte->name;
                    } else return false;
                })
                ->filterColumn('deporte', function ($query, $keyword) {
                    $query->whereRaw("deportes.name like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['actions'])
                ->make(true);

        }

        return view('athletes.print');
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

        $seleccionados=count($imp_cred);
//dd($seleccionados);
        if ($seleccionados>4) {
           return redirect()->route('print_athletes')->with('message_danger', 'Solo puede seleccionar 4 personas a la ves para imprimir sus credenciales')->withInput();
        }

        if (!is_null($imp_cred)) {
            $credenciales = Athlete::with('provincia', 'deporte')->whereIn('id', $imp_cred)->get();
            $posicion = 0;
            set_time_limit(0);
            ini_set('memory_limit', '1G');
            $pdf = PDF::loadView('reportes.credenciales-pdf', compact('credenciales', 'posicion'));
            return $pdf->stream('Credenciales');//imprime en pantalla
        } else {
            return redirect()->back()->with('message_danger', 'Seleccione los atletas  que desees imprimir sus credenciales');
        }

    }


    /**
     * Vista con la lista de participantes a acreditar
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAcreditar()
    {
        return view('athletes.acreditar');
    }


    /**
     * Obtener todos los atltetas para datatables para acreditar
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllAcreditar(Request $request)
    {
        if ($request->ajax()) {

            $atletas = Athlete::with('provincia', 'deporte')
                ->where('athletes.status', '!=', Athlete::ATLETA_INACTIVO)
                ->where('acreditado', Athlete::ATLETA_NO_ACREDITADO)
                ->select('athletes.*');

            $action_buttons = '
                 
                <a href="#">
                {!! Form::checkbox(\'acreditar[]\',$id,false,[\'id\'=>$id]) !!}
                </a>
               
                ';

            return Datatables::eloquent($atletas)
                ->addColumn('actions', $action_buttons)
                ->addColumn('provincia', function (Athlete $atleta) {
                    return $atleta->provincia->province;
                })
                ->filterColumn('provincia', function ($query, $keyword) {
                    $query->whereRaw("provincias.province like ?", ["%{$keyword}%"]);
                })
                ->addColumn('deporte', function (Athlete $atleta) {
                    if (isset($atleta->deporte)) {
                        return $atleta->deporte->name;
                    } else return false;
                })
                ->filterColumn('deporte', function ($query, $keyword) {
                    $query->whereRaw("deportes.name like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('athletes.acreditar');
    }

    /**
     * Acreditar participantes seleccionados
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function acreditar(Request $request)
    {
        try {
            DB::beginTransaction();

            $acreditar = $request->input('acreditar');

            if (count($acreditar) > 0) {
                $cont = 0;
                while ($cont < count($acreditar)) {
                    $athleta = Athlete::where('id', $acreditar[$cont])->first();
                    $athleta->acreditado = Athlete::ATLETA_ACREDITADO;
                    $cont++;
                    $athleta->update();
                }
            } else {
                return redirect()->back()->with('message_danger', 'Debe seleccionar los participantes que desea acreditar');
            }

            DB::commit();
            return redirect()->back()->with('message', 'Participantes acreditados');

        } catch (\Exception $e) {
            DB::rollback();
            $message = "Error al acreditadar a los participantes";
            return redirect()->back()->with('message_danger', $message)->withInput();
            //return redirect()->back()->with('message_danger',$e->getMessage())->withInput();
        }

    }


    /**
     * Vista con la lista de participantes a acreditar
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAcreditados()
    {
        return view('athletes.acreditados');
    }


    /**
     * Obtener todos los atltetas para datatables para acreditar
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllAcreditados(Request $request)
    {
        if ($request->ajax()) {

            $atletas = Athlete::with('provincia', 'deporte')
                ->where('athletes.status', '!=', Athlete::ATLETA_INACTIVO)
                ->where('acreditado', Athlete::ATLETA_ACREDITADO)
                ->select('athletes.*');

            $action_buttons = '
                 
                <a href="!#">
                {!! Form::checkbox(\'acreditar[]\',$id,false,[\'id\'=>$id]) !!}
                </a>
               
                ';

            return Datatables::eloquent($atletas)
                ->addColumn('actions', $action_buttons)
                ->addColumn('provincia', function (Athlete $atleta) {
                    return $atleta->provincia->province;
                })
                ->filterColumn('provincia', function ($query, $keyword) {
                    $query->whereRaw("provincias.province like ?", ["%{$keyword}%"]);
                })
                ->addColumn('deporte', function (Athlete $atleta) {
                    if (isset($atleta->deporte)) {
                        return $atleta->deporte->name;
                    } else return false;
                })
                ->filterColumn('deporte', function ($query, $keyword) {
                    $query->whereRaw("deportes.name like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('athletes.acreditados');
    }



}