<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forcastdata extends Model {

    public $timestamps = false;
    protected $table = 'forcusted_headcount';
    
    public static function getForecastData($year, $org_type, $emp_type=''){
        //echo "$emp_type"; exit;
        $total = 0;
        $return_data = array();
        if ($org_type == 'Div') {
            $data = Forcastdata::Where("forcust_year", "=", "$year")
                    ->Where("organization_type", "=", "$org_type")                             
                    ->get();
            foreach ($data as $item) {
                if($emp_type == 'Regular'){
                    $return_data[$item['organization_name']] = $item['total_regular'];
                    $total = $total + $item['total_regular'];
                }elseif($emp_type == 'Contractual'){
                    $return_data[$item['organization_name']] = $item['band_g_full'];
                    $total = $total + $item['band_g_full'];
                }elseif($emp_type == 'Apprentice'){
                     $return_data[$item['organization_name']] = $item['band_g_app'];
                     $total = $total + $item['band_g_app'];
                }else{
                    $return_data[$item['organization_name']] = $item['total'];
                    $total = $total + $item['total'];
                }              
            }
        }       
        $return_data['Total'] = $total;
        return $return_data;
        
    }

}
