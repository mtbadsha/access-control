<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Forcastemployee;

class ForcastemployeeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $employees = Forcastemployee::all();
        return View('forecastemployee.index', compact('employees'));
    }

    public function getNew() {
        return View('forecastemployee.create');
    }

    public function postNew() {
        ini_set('memory_limit','2560M');
        ini_set('post_max_size','2560M');
        ini_set('upload_max_filesize','2560M');

        $file = Input::file('employee_data'); 
        $input_date = Input::get('input_date');


        Forcastemployee::whereRaw("id > 0")->delete();
        \DB::table('forecast_employee')->truncate();

        $destinationPath = public_path() . '/uploads/forcastdata/';
           
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
            if($data[19] != '#N/A' || $data[21] != '#N/A'){
                $forecast_obj = new Forcastemployee();            
                $forecast_obj->data_date = $input_date;            
                $forecast_obj->local_id = $data[0];
                $forecast_obj->global_id = $data[51];

                $div = explode('-', $data[19]);
                $forecast_obj->div_name = $div[2];
                $dept = explode('-', $data[21]);
                $forecast_obj->dept_name = str_replace('BD-Dept-', '', $dept[2]);

                $forecast_obj->category = $data[8];
                $forecast_obj->time_type = $data[9];
                $forecast_obj->status = $data[6];

                $forecast_obj->save();
            }
        }
        $employees = Forcastemployee::all();
        return View('forecastemployee.index', compact('employees'));
    }

}
