<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forcastemployee extends Model {

    public $timestamps = false;
    protected $table = 'forecast_employee';
        
    public static function getForecastData($org_type, $emp_type=''){
        $return_data = array();
        $total = 0;
        if ($org_type == 'Div') {            
            $data = self::getDivisionList();
            foreach ($data as $item) {
                if($emp_type == 'Regular'){
                    $count = Forcastemployee::query()
                            ->where('div_name', '=', $item['div_name'])
                            ->where('category','=','Permanent')
                            ->where('time_type','=','Full Time');
                }elseif($emp_type == 'Contractual'){
                    $count = Forcastemployee::query()
                            ->where('div_name', '=', $item['div_name'])
                            ->where('category','=','Fixed term')
                            ->where('time_type','=','Full Time');
                }elseif($emp_type == 'Apprentice'){
                    $count = Forcastemployee::query()
                            ->where('div_name', '=', $item['div_name'])
                            ->where('category','=','Fixed term')
                            ->where('time_type','=','Part Time');
                }else{
                    $count = Forcastemployee::query()
                            ->where('div_name', '=', $item['div_name']);                            
                }
                $return_data[$item['div_name']] = $count->count(); 
                $total = $total + $count->count(); 
            }             
        }
        $return_data['Total'] = $total;
        return $return_data;
    }
    
    public static function getDivisionList(){
        $data = Forcastemployee::query()
                    ->select('div_name')
                    ->groupBy('div_name')
                    ->get();
        return $data;
    }
    
    public static function getAsOfDate(){
        $date = Forcastemployee::query()->where('id','=','1')->get();
        foreach ($date as $data){
            return $data['data_date']; 
        }
    }

}
