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


        Excel::create('Athletes Credentials' . ' - ' . Carbon::now() . '', function ($excel) use ($atletas_array) {//crear excel pasando array al closure

            $excel->sheet('Credentials-Template', function ($sheet) use ($atletas_array) {//crear la hoja pasando array al closure


                $sheet->mergeCells('A1:E1');
                $sheet->cells('A1:E2', function ($cells) {
                    $cells->setFontColor('#ffffff');
                    //$cells->setBackground('#B2B2B2');
                    $cells->setBackground('#404040');
                    $cells->setFontWeight('bold');
                    //alineacion horizontal
                    $cells->setAlignment('center');
                    // alineacion vertical
                    $cells->setValignment('center');
                    // tipo de letra
                    $cells->setFontFamily('Arial');
                    // tamaño de letra
                    $cells->setFontSize(11);
                    // bordes (top, right, bottom, left)
//                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });
                //planificado
                $sheet->cells('F1:F2', function ($cells) {
                    $cells->setFontColor('#ffffff');
                    $cells->setBackground('#4472C4');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontFamily('Arial');
                    $cells->setFontSize(11);
                });
                //devengado
                $sheet->cells('G1:G2', function ($cells) {
                    $cells->setFontColor('#ffffff');
                    $cells->setBackground('#00B050');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontFamily('Arial');
                    $cells->setFontSize(11);
                });
                //diferencia
                $sheet->cells('H1:H2', function ($cells) {
                    $cells->setFontColor('#ffffff');
                    $cells->setBackground('#ED9131');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontFamily('Arial');
                    $cells->setFontSize(11);
                });

                // Set all margins
//                $sheet->setPageMargin(0.25);
                // Set top, right, bottom, left margins
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));

                // Set font with ->setStyle()`
                $sheet->setStyle([
                    // Font family
                    $sheet->setFontFamily('Arial'),
                    // Font size
                    $sheet->setFontSize(12),
                    // Font bold
                    $sheet->setFontBold(false),
                    // Sets all borders
                    $sheet->setAllBorders('thin'),
                ]);

                // freeze fila
                $sheet->setFreeze('F3');

                $sheet->setColumnFormat([
                    'F' => '#,##0.00',
                    'G' => '#,##0.00',
                    'H' => '#,##0.00',
                ]);

                $sheet->setAutoFilter('A2:E2');

                //crear la hoja a partir del array
                //5to parametro false pasa como encabesado de la primera fila los nombres de las columnas
                $sheet->fromArray($atletas_array, null, 'A2', false, false);

            });
        })->export('xlsx');

    }


    public function generate2()
    {

//        $historico_mes = Athlete::query()->limit(10);
//
//        dd($historico_mes);
//
//        $meses=Month::where('cod',$mes_cod)->first();
//        $encabezado = [
//            'mes' => $meses->month,
//        ];
//
//
//        $hist_mes_array[] = ['Responsable', 'Programa', 'Actividad', 'Item', 'Nombre del Item', 'Planificado', 'Devengado', 'Diferencia'];
//        foreach ($historico_mes as $hm) {
//            $dev = $hm->devengado - $hm->extras;
//            $dif = (float)$hm->planificado - $dev;
//            $hist_mes_array[] = [
//                'resp' => $hm->area,
//                'cod_prog' => $hm->cod_programa,
//                'cod_act' => $hm->cod_actividad,
//                'cod_it' => $hm->cod_item,
//                'item' => $hm->item,
//                'plan' => $hm->planificado != 0 ? (float)$hm->planificado : '-',
//                'devengado' => $dev != 0 ? $dev : '-',
//                'diferencia' => $dif != 0 ? $dif : '-',
//            ];
//        }
//
//        Excel::create('Historico Control Poa ' . $meses->month . ' - ' . Carbon::now() . '', function ($excel) use ($hist_mes_array, $encabezado) {//crear excel pasando array al closure
//
//            $excel->sheet('POA - ' . $encabezado['mes'] . '', function ($sheet) use ($hist_mes_array, $encabezado) {//crear la hoja pasando array al closure
//
//                $sheet->row(1, ["Mes: " . $encabezado['mes']]);
//                $sheet->mergeCells('A1:E1');
//                $sheet->cells('A1:E2', function ($cells) {
//                    $cells->setFontColor('#ffffff');
//                    //$cells->setBackground('#B2B2B2');
//                    $cells->setBackground('#404040');
//                    $cells->setFontWeight('bold');
//                    //alineacion horizontal
//                    $cells->setAlignment('center');
//                    // alineacion vertical
//                    $cells->setValignment('center');
//                    // tipo de letra
//                    $cells->setFontFamily('Arial');
//                    // tamaño de letra
//                    $cells->setFontSize(11);
//                    // bordes (top, right, bottom, left)
////                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
//                });
//                //planificado
//                $sheet->cells('F1:F2', function ($cells) {
//                    $cells->setFontColor('#ffffff');
//                    $cells->setBackground('#4472C4');
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//                    $cells->setValignment('center');
//                    $cells->setFontFamily('Arial');
//                    $cells->setFontSize(11);
//                });
//                //devengado
//                $sheet->cells('G1:G2', function ($cells) {
//                    $cells->setFontColor('#ffffff');
//                    $cells->setBackground('#00B050');
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//                    $cells->setValignment('center');
//                    $cells->setFontFamily('Arial');
//                    $cells->setFontSize(11);
//                });
//                //diferencia
//                $sheet->cells('H1:H2', function ($cells) {
//                    $cells->setFontColor('#ffffff');
//                    $cells->setBackground('#ED9131');
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//                    $cells->setValignment('center');
//                    $cells->setFontFamily('Arial');
//                    $cells->setFontSize(11);
//                });
//
//                // Set all margins
////                $sheet->setPageMargin(0.25);
//                // Set top, right, bottom, left margins
//                $sheet->setPageMargin(array(
//                    0.25, 0.30, 0.25, 0.30
//                ));
//
//                // Set font with ->setStyle()`
//                $sheet->setStyle([
//                    // Font family
//                    $sheet->setFontFamily('Arial'),
//                    // Font size
//                    $sheet->setFontSize(12),
//                    // Font bold
//                    $sheet->setFontBold(false),
//                    // Sets all borders
//                    $sheet->setAllBorders('thin'),
//                ]);
//
//                // freeze fila
//                $sheet->setFreeze('F3');
//
//                $sheet->setColumnFormat([
//                    'F' => '#,##0.00',
//                    'G' => '#,##0.00',
//                    'H' => '#,##0.00',
//                ]);
//
//                $sheet->setAutoFilter('A2:E2');
//
//                //crear la hoja a partir del array
//                //5to parametro false pasa como encabesado de la primera fila los nombres de las columnas
//                $sheet->fromArray($hist_mes_array, null, 'A2', false, false);
//
//            });
//        })->export('xlsx');
//
//    } else {
//    //historico completo
//
//$historico_mes = Esigef::
//select('id', 'area', 'cod_programa', 'cod_actividad', 'cod_item', 'item', DB::raw('
//                        CASE WHEN mes = \'1\' THEN planificado ELSE 0 END AS p_ene,
//                        CASE WHEN mes = \'2\' THEN planificado ELSE 0 END AS p_feb,
//                        CASE WHEN mes = \'3\' THEN planificado ELSE 0 END AS p_mar,
//                        CASE WHEN mes = \'4\' THEN planificado ELSE 0 END AS p_abr,
//                        CASE WHEN mes = \'5\' THEN planificado ELSE 0 END AS p_may,
//                        CASE WHEN mes = \'6\' THEN planificado ELSE 0 END AS p_jun,
//                        CASE WHEN mes = \'7\' THEN planificado ELSE 0 END AS p_jul,
//                        CASE WHEN mes = \'8\' THEN planificado ELSE 0 END AS p_ago,
//                        CASE WHEN mes = \'9\' THEN planificado ELSE 0 END AS p_sep,
//                        CASE WHEN mes = \'10\' THEN planificado ELSE 0 END AS p_oct,
//                        CASE WHEN mes = \'11\' THEN planificado ELSE 0 END AS p_nov,
//                        CASE WHEN mes = \'12\' THEN planificado ELSE 0 END AS p_dic,
//                        CASE WHEN mes = \'1\' THEN devengado-extras ELSE 0 END AS dev_ene,
//                        CASE WHEN mes = \'2\' THEN devengado-extras ELSE 0 END AS dev_feb,
//                        CASE WHEN mes = \'3\' THEN devengado-extras ELSE 0 END AS dev_mar,
//                        CASE WHEN mes = \'4\' THEN devengado-extras ELSE 0 END AS dev_abr,
//                        CASE WHEN mes = \'5\' THEN devengado-extras ELSE 0 END AS dev_may,
//                        CASE WHEN mes = \'6\' THEN devengado-extras ELSE 0 END AS dev_jun,
//                        CASE WHEN mes = \'7\' THEN devengado-extras ELSE 0 END AS dev_jul,
//                        CASE WHEN mes = \'8\' THEN devengado-extras ELSE 0 END AS dev_ago,
//                        CASE WHEN mes = \'9\' THEN devengado-extras ELSE 0 END AS dev_sep,
//                        CASE WHEN mes = \'10\' THEN devengado-extras ELSE 0 END AS dev_oct,
//                        CASE WHEN mes = \'11\' THEN devengado-extras ELSE 0 END AS dev_nov,
//                        CASE WHEN mes = \'12\' THEN planificado-(devengado-extras) ELSE 0 END AS dev_dic,
//                        CASE WHEN mes = \'1\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_ene,
//                        CASE WHEN mes = \'2\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_feb,
//                        CASE WHEN mes = \'3\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_mar,
//                        CASE WHEN mes = \'4\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_abr,
//                        CASE WHEN mes = \'5\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_may,
//                        CASE WHEN mes = \'6\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_jun,
//                        CASE WHEN mes = \'7\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_jul,
//                        CASE WHEN mes = \'8\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_ago,
//                        CASE WHEN mes = \'9\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_sep,
//                        CASE WHEN mes = \'10\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_oct,
//                        CASE WHEN mes = \'11\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_nov,
//                        CASE WHEN mes = \'12\' THEN planificado-(devengado-extras) ELSE 0 END AS dif_dic
//
//                '))
//->where('ejercicio', $ejercicio)
//->groupBy('id', 'area', 'cod_programa', 'cod_actividad', 'cod_item', 'item')
//->get();
//
//$hist_array[] = ['RESPONSABLE', 'PROGRAMA', 'ACTIVIDAD', 'ITEM', 'NOMBRE DEL ITEM', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
//
//foreach ($historico_mes as $hm) {
////                $dev=$hm->devengado-$hm->extras;
////                $dif=(float)$hm->planificado-$dev;
//$hist_array[] = [
//'resp' => $hm->area,
//'cod_prog' => $hm->cod_programa,
//'cod_act' => $hm->cod_actividad,
//'cod_it' => $hm->cod_item,
//'item' => $hm->item,
//'p_ene' => $hm->p_ene != 0 ? (float)$hm->p_ene : '-',
//'p_feb' => $hm->p_feb != 0 ? (float)$hm->p_feb : '-',
//'p_mar' => $hm->p_mar != 0 ? (float)$hm->p_mar : '-',
//'p_abr' => $hm->p_abr != 0 ? (float)$hm->p_abr : '-',
//'p_may' => $hm->p_may != 0 ? (float)$hm->p_may : '-',
//'p_jun' => $hm->p_jun != 0 ? (float)$hm->p_jun : '-',
//'p_jul' => $hm->p_jul != 0 ? (float)$hm->p_jul : '-',
//'p_ago' => $hm->p_ago != 0 ? (float)$hm->p_ago : '-',
//'p_sep' => $hm->p_sep != 0 ? (float)$hm->p_sep : '-',
//'p_oct' => $hm->p_oct != 0 ? (float)$hm->p_oct : '-',
//'p_nov' => $hm->p_nov != 0 ? (float)$hm->p_nov : '-',
//'p_dic' => $hm->p_dic != 0 ? (float)$hm->p_dic : '-',
//'dev_ene' => $hm->dev_ene != 0 ? (float)$hm->dev_ene : '-',
//'dev_feb' => $hm->dev_feb != 0 ? (float)$hm->dev_feb : '-',
//'dev_mar' => $hm->dev_mar != 0 ? (float)$hm->dev_mar : '-',
//'dev_abr' => $hm->dev_abr != 0 ? (float)$hm->dev_abr : '-',
//'dev_may' => $hm->dev_may != 0 ? (float)$hm->dev_may : '-',
//'dev_jun' => $hm->dev_jun != 0 ? (float)$hm->dev_jun : '-',
//'dev_jul' => $hm->dev_jul != 0 ? (float)$hm->dev_jul : '-',
//'dev_ago' => $hm->dev_ago != 0 ? (float)$hm->dev_ago : '-',
//'dev_sep' => $hm->dev_sep != 0 ? (float)$hm->dev_sep : '-',
//'dev_oct' => $hm->dev_oct != 0 ? (float)$hm->dev_oct : '-',
//'dev_nov' => $hm->dev_nov != 0 ? (float)$hm->dev_nov : '-',
//'dev_dic' => $hm->dev_dic != 0 ? (float)$hm->dev_dic : '-',
//'dif_ene' => $hm->dif_ene == 0 ? '-' : (float)$hm->dif_ene,
//'dif_feb' => $hm->dif_feb == 0 ? '-' : (float)$hm->dif_feb,
//'dif_mar' => $hm->dif_mar == 0 ? '-' : (float)$hm->dif_mar,
//'dif_abr' => $hm->dif_abr == 0 ? '-' : (float)$hm->dif_abr,
//'dif_may' => $hm->dif_may == 0 ? '-' : (float)$hm->dif_may,
//'dif_jun' => $hm->dif_jun == 0 ? '-' : (float)$hm->dif_jun,
//'dif_jul' => $hm->dif_jul == 0 ? '-' : (float)$hm->dif_jul,
//'dif_ago' => $hm->dif_ago == 0 ? '-' : (float)$hm->dif_ago,
//'dif_sep' => $hm->dif_sep == 0 ? '-' : (float)$hm->dif_sep,
//'dif_oct' => $hm->dif_oct == 0 ? '-' : (float)$hm->dif_oct,
//'dif_nov' => $hm->dif_nov == 0 ? '-' : (float)$hm->dif_nov,
//'dif_dic' => $hm->dif_dic == 0 ? '-' : (float)$hm->dif_dic,
//];
//}
//
//Excel::create('Historico ' . $ejercicio . ' - ' . Carbon::now() . '', function ($excel) use ($hist_array) {
//
//    $excel->sheet('Control POA', function ($sheet) use ($hist_array) {//crear la hoja pasando array al closure
//
//        $sheet->setOrientation('landscape');
//
////                $sheet->setMergeColumn(array(
////                    'columns' => array('A','B','C','D'),
////                    'rows' => array(
////                        array(1,2),
////                        array(12,16),
////                    )
////                ));
//
//        $sheet->cells('A1:E1', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#404040');
//            $cells->setFontWeight('bold');
//            //alineacion horizontal
//            $cells->setAlignment('left');
//            // alineacion vertical
//            $cells->setValignment('center');
//            // tipo de letra
//            $cells->setFontFamily('Arial');
//            // tamaño de letra
//            $cells->setFontSize(11);
//            // bordes (top, right, bottom, left)
//            //$cells->setBorder('solid', 'solid', 'solid', 'solid');
//            //$cells->setBorder('thin', 'solid', 'solid', 'solid');
//        });
//        $sheet->cells('A2:E2', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#404040');
//            $cells->setFontWeight('bold');
//            $cells->setAlignment('left');
//            $cells->setValignment('center');
//            $cells->setFontFamily('Arial');
//            $cells->setFontSize(11);
//        });
//
//        $sheet->setCellValue('F1', 'PLANIFICADO MENSUAL');
//        $sheet->mergeCells('F1:Q1');
//        $sheet->cells('F1:Q1', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#4472C4');
//            $cells->setFontWeight('bold');
//            $cells->setAlignment('center');
//            $cells->setValignment('center');
//            $cells->setFontFamily('Arial');
//            $cells->setFontSize(11);
//        });
//        $sheet->cells('F2:Q2', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#4472C4');
//            $cells->setFontWeight('bold');
//            $cells->setAlignment('center');
//            $cells->setValignment('center');
//            $cells->setFontFamily('Arial');
//            $cells->setFontSize(11);
//        });
//
//        $sheet->mergeCells('R1:AC1');
//        $sheet->setCellValue('R1', 'DEVENGADO ESIGEF');
//        $sheet->cells('R1:AC1', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#00B050');
//            $cells->setFontWeight('bold');
//            $cells->setAlignment('center');
//            $cells->setValignment('center');
//            $cells->setFontFamily('Arial');
//            $cells->setFontSize(11);
//        });
//        $sheet->cells('R2:AC2', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#00B050');
//            $cells->setFontWeight('bold');
//            $cells->setAlignment('center');
//            $cells->setValignment('center');
//            $cells->setFontFamily('Arial');
//            $cells->setFontSize(11);
//        });
//
//        $sheet->mergeCells('AD1:AO1');
//        $sheet->setCellValue('AD1', 'DIFERENCIAS PLANIFICADO VS DEVENGADO');
//        $sheet->cells('AD1:AO1', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#ED9131');
//            $cells->setFontWeight('bold');
//            $cells->setAlignment('center');
//            $cells->setValignment('center');
//            $cells->setFontFamily('Arial');
//            $cells->setFontSize(11);
//        });
//        $sheet->cells('AD2:AO2', function ($cells) {
//            $cells->setFontColor('#ffffff');
//            $cells->setBackground('#ED9131');
//            $cells->setFontWeight('bold');
//            $cells->setAlignment('center');
//            $cells->setValignment('center');
//            $cells->setFontFamily('Arial');
//            $cells->setFontSize(11);
//        });
//
//        // Set all margins
////                $sheet->setPageMargin(0.25);
//        // Set top, right, bottom, left margins
//        $sheet->setPageMargin(array(
//            0.25, 0.30, 0.25, 0.30
//        ));
//
//        // Set font with ->setStyle()
//        $sheet->setStyle([
//            // Font family
//            $sheet->setFontFamily('Arial'),
//            // Font size
//            $sheet->setFontSize(12),
//            // Font bold
//            $sheet->setFontBold(false),
//            // Sets all borders
//            // $sheet->setAllBorders('thin'),
//        ]);
//
//        // freeze fila
//        $sheet->setFreeze('F3');
//
//        $sheet->setAutoFilter('A2:E2');
//
//        // Set multiple column formats
//        $sheet->setColumnFormat(array(
//            'F:AO' => '#,##0.00'
//        ));
//
////                    $sheet->setColumnFormat([
////                        'F'=>'',
////
////                    ]);
//
//
//        //crear la hoja a partir del array
//        //5to parametro false pasa como encabesado de la primera fila los nombres de las columnas
//        $sheet->fromArray($hist_array, null, 'A2', false, false);
//
//    });
//})->export('xlsx');
//

    }

}
