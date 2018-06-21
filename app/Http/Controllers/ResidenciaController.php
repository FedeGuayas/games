<?php

namespace App\Http\Controllers;

use App\Residencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $residencias=Residencia::where('status',Residencia::RESIDENCIA_ACTIVO)->get();

        return view('residencias.index',compact('residencias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('residencias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $nombre=strtoupper($request->input('name'));
            $capacidad=$request->input('capacidad');

            $residencia=new Residencia();
            $residencia->name=$nombre;
            $residencia->capacidad=$capacidad;
            $residencia->save();

            DB::commit();


        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('message_danger', 'Ha ocurrido un error al crear el registro');
//            return redirect()->back()->with('message_danger',$e->getMessage());
        }

        return redirect()->route('residencias.index')->with('message','Residencia creada correctamente');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $residencia = Residencia::where('id', $id)->first();

        return view('residencias.edit', compact('residencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $residencia=Residencia::where('id',$id)->first();

            $nombre=strtoupper($request->input('name'));
            $capacidad=$request->input('capacidad');

            $residencia->name=$nombre;
            $residencia->capacidad=$capacidad;
            $residencia->update();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('message_danger', 'Ha ocurrido un error al crear el registro');
//            return redirect()->back()->with('message_danger',$e->getMessage());
        }

        return redirect()->route('residencias.index')->with('message','Residencia actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->ajax()) {

            try {

                DB::beginTransaction();

                $residencia = Residencia::where('id', $id)->first();
                $residencia->status = Residencia::RESIDENCIA_INACTIVO;
                $residencia->update();

                DB::commit();

            } catch (\Exception $e) {

                DB::rollback();
                return response()->json(['rep' => 'Ocurrio un error, no se pudo realizar la acción']);
            }
            return response()->json(['resp' => 'Residencia inhabilitada!']);
        }
        return redirect()->route('residencias.index');
    }
}
