<?php

namespace App\Http\Controllers;

use App\Athlete;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function generate()
    {

        $atletas = Athlete::query()->get()->take(10);

        $atletas_array = [];
        foreach ($atletas as $a) {

            $atletas_array[] = [
                "sport" => $a->sport,
                "document" => $a->document,
                "last_name" => $a->last_name,
                "name" => $a->name,
                "provincia" => $a->provincia,
                "funcion" => $a->funcion,
            ];
        }



    }




}
