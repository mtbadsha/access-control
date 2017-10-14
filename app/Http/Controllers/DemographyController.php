<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Forcastdata;
use App\Forcastemployee;

class DemographyController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getHeadcountTrending() {
        $type = '';
        $from = '';
        $to = '';
        $graph_data = '0';
        $graph_data_contractual = '0';
        return View('demography.bar_chart', compact('graph_data', 'graph_data_contractual', 'from', 'to', 'type'));
    }

    public function postHeadcountTrending() {

        $type = Input::get('type');
        $from = Input::get('from');
        $to = Input::get('to');

        $graph_data = \App\EmployeeDemography::employeeTrendingRegular($from, $to, $type);
        $graph_data_contractual = \App\EmployeeDemography::employeeTrendingContractual($from, $to, $type);

        return View('demography.bar_chart', compact('graph_data', 'graph_data_contractual', 'from', 'to', 'type'));
    }

    public function getDiversityHiringVsTernover() {
        $from = '';
        $to = '';
        $graph_data = '0';
        $graph_data_contractual = '0';
        return View('demography.diversity_hire_trending', compact('graph_data', 'graph_data_contractual', 'from', 'to'));
    }

    public function postDiversityHiringVsTernover() {
        $from = Input::get('from') . '<br>';
        $to = Input::get('to');
        $diversity_data = \App\EmployeeDemography::getDiversityData($from, $to);
        $graph_data = '0';
        $graph_data_contractual = '0';
        return View('demography.diversity_hire_trending', compact('graph_data', 'graph_data_contractual', 'from', 'to'));
    }

    public function getForecastedHeadcount() {
        $total_employee = '0';
        $total_regular = '0';
        $total_apprentice = '0';
        $total_contractual = '0';
        $year = '';
        $as_of_data = Forcastemployee::getAsOfDate();
        return View('demography.forecasted_headcount', compact('total_apprentice','total_contractual','total_regular', 'total_employee', 'as_of_data' ,'year'));
    }

    public function postForecastedHeadcount() {
        $year = Input::get('monthPicker');
        $as_of_data = Forcastemployee::getAsOfDate();
         
        
        // for all employee
        $division_forecast = Forcastdata::getForecastData($year, 'Div');
        $actual_worker = Forcastemployee::getForecastData('Div');
        $total_employee = self::graph_data_generate($division_forecast, $actual_worker);
        
        //for regular employee
        $division_forecast_fulltime = Forcastdata::getForecastData($year, 'Div', 'Regular');        
        $actual_worker_fulltime = Forcastemployee::getForecastData('Div', 'Regular');
        $total_regular = self::graph_data_generate($division_forecast_fulltime, $actual_worker_fulltime);
        
        //for contractual employee
        $division_forecast_contractual = Forcastdata::getForecastData($year, 'Div', 'Contractual');        
        $actual_worker_contractual = Forcastemployee::getForecastData('Div', 'Contractual');
        $total_contractual = self::graph_data_generate($division_forecast_contractual, $actual_worker_contractual);
        
        //for Apprentice employee
        $division_forecast_apprentice = Forcastdata::getForecastData($year, 'Div', 'Apprentice');        
        $actual_worker_apprentice = Forcastemployee::getForecastData('Div', 'Apprentice');
        $total_apprentice = self::graph_data_generate($division_forecast_apprentice, $actual_worker_apprentice);
        
        
        /*echo "<pre>";
        print_r($division_forecast_apprentice);
        print_r($actual_worker_apprentice);
        exit;*/
                
        return View('demography.forecasted_headcount', compact('total_apprentice','total_contractual','total_regular', 'total_employee', 'as_of_data' ,'year'));
    }

    public static function graph_data_generate($forecast, $actual) {
        $total_graph = array();
        $total_index = 0;
        foreach ($forecast as $key => $data) {
            $total_graph[$total_index]['div_name'] = $key;
            $total_graph[$total_index]['forecast_data'] = $data;
            $total_graph[$total_index]['actual_worker'] = $actual[$key];
            $total_index++;
        }
        return json_encode($total_graph);
    }

}
