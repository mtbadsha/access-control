<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Forcastdata;

class ForcastdataController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $forcast_data = \App\Forcastdata::all();
        return View('forcastdata.index', compact('forcast_data'));
    }

    public function getNew() {
        return View('forcastdata.create');
    }

    public function postNew() {
        $file = Input::file('forecast_data');
        $forecast_date = Input::get('myDate');
        
        
        Forcastdata::whereRaw("forcust_year = $forecast_date")->delete(); 
        \DB::table('forcusted_headcount')->truncate();
                
        $destinationPath = public_path() . '/uploads/forcastdata/';

        // clear previously loadd data        
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = date('Y-m-d-H-i-s') . '-' . $filename;

        $file->move($destinationPath, $filename);

        $load_file = $destinationPath . $filename;
        // process data for detail table
        $objPHPExcel = \PHPExcel_IOFactory::load($load_file);
        $loadData = $objPHPExcel->getActiveSheet()->toArray();
        unset($loadData[0]);

        foreach ($loadData as $data) {
            $forecast_obj = new \App\Forcastdata();
            $org = explode('-', $data[0]);
            
            if (count($org) > 1) {
                $forecast_obj->forcust_year = $forecast_date;
                $forecast_obj->organization_name = $org[2];
                $forecast_obj->organization_type = $org[1];
                $forecast_obj->band_a = str_replace(',', '', $data[1]);
                $forecast_obj->band_b = str_replace(',', '', $data[2]);
                $forecast_obj->band_c = str_replace(',', '', $data[3]);
                $forecast_obj->band_d = str_replace(',', '', $data[4]);
                $forecast_obj->band_e = str_replace(',', '', $data[5]);
                $forecast_obj->band_f = str_replace(',', '', $data[6]);
                $forecast_obj->band_g_app = str_replace(',', '', $data[7]);
                $forecast_obj->band_g_full = str_replace(',', '', $data[8]);
                $forecast_obj->total_regular = (
                        str_replace(',', '', $data[1])+
                        str_replace(',', '', $data[2])+
                        str_replace(',', '', $data[3])+
                        str_replace(',', '', $data[4])+
                        str_replace(',', '', $data[5])+
                        str_replace(',', '', $data[6])                        
                        );
                $forecast_obj->total_part_time = (
                        str_replace(',', '', $data[7])+
                        str_replace(',', '', $data[8])                       
                        );
                $forecast_obj->total = (
                        str_replace(',', '', $data[1])+
                        str_replace(',', '', $data[2])+
                        str_replace(',', '', $data[3])+
                        str_replace(',', '', $data[4])+
                        str_replace(',', '', $data[5])+
                        str_replace(',', '', $data[6])+
                        str_replace(',', '', $data[7])+
                        str_replace(',', '', $data[8])
                        );
                $forecast_obj->save();
            }
        }
        unlink($load_file);
        $forcast_data = \App\Forcastdata::all();
        return View('forcastdata.index', compact('forcast_data'));
    }

}
