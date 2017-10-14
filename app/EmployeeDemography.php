<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class EmployeeDemography extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee_demography';

    public static function employeeTrendingRegular($from, $to, $type) {
        $time = strtotime($from);
        $from_year = date("Y", $time);
        $from_month = date("m", $time);

        $time2 = strtotime($to);
        $to_month = date("m", $time2);
        $to_year = date("Y", $time2);

        if (intval($from_year . $from_month) > intval($to_year . $to_month) || $from_year > $to_year) {
            return Redirect::back();
        }       
        $data = null;
        $key = 0;
        if ($type == "monthly") {            
            for ($i = $from_year; $i <= $to_year; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $employee_date = $i . '-' . sprintf("%'.02d", $j) . '%';
                    if (intval($i . sprintf("%'.02d", $j)) >= intval($from_year . sprintf("%'.02d", $from_month)) && intval($i . sprintf("%'.02d", $j)) <= intval($to_year . sprintf("%'.02d", $to_month))) {

                        $demography = \App\EmployeeDemography::where('employee_date_start', 'LIKE', $employee_date)
                            ->where('category', '=', 'Permanent')
                            ->where('time_type', '=', 'Full Time');
                        $data[$key]['total'] = $demography->count();
                        $data[$key]['period'] = date('M-Y', strtotime($i . '-' . sprintf("%'.02d", $j) . '-01'));
                        $key++;
                    }
                }
            }
        } else {            
            for ($i = $from_year; $i <= $to_year; $i++) {

                $demography = \App\EmployeeDemography::where('employee_date_start', 'LIKE', $i . '%')
                        ->where('category', '=', 'Permanent')
                        ->where('time_type', '=', 'Full Time')
                        ->groupBy('demography_id')
                        ->get();

                $data[$key]['total'] = $demography->count();
                $data[$key]['period'] = $i;
                $key++;
            }
        }
        return json_encode($data);
    }

    public static function employeeTrendingContractual($from, $to, $type) {
        $time = strtotime($from);
        $from_year = date("Y", $time);
        $from_month = date("m", $time);

        $time2 = strtotime($to);
        $to_month = date("m", $time2);
        $to_year = date("Y", $time2);

        if (intval($from_year . $from_month) > intval($to_year . $to_month) || $from_year > $to_year) {
            return Redirect::back();
        }       
        $data = null;
        $key = 0;
        if ($type == "monthly") {            
            for ($i = $from_year; $i <= $to_year; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $employee_date = $i . '-' . sprintf("%'.02d", $j) . '%';
                    if (intval($i . sprintf("%'.02d", $j)) >= intval($from_year . sprintf("%'.02d", $from_month)) && intval($i . sprintf("%'.02d", $j)) <= intval($to_year . sprintf("%'.02d", $to_month))){
                        $demography = \App\EmployeeDemography::where('employee_date_start', 'LIKE', $employee_date)
                            ->where('category', '=', 'Fixed Term')
                            ->where('time_type', '=', 'Full Time');
                    $data[$key]['total'] = $demography->count();
                    $data[$key]['period'] = date('M-Y', strtotime($i . '-' . sprintf("%'.02d", $j) . '-01'));
                    $key++;
                }
                }
            }
        } else {            
            for ($i = $from_year; $i <= $to_year; $i++) {

                $demography = \App\EmployeeDemography::where('employee_date_start', 'LIKE', $i . '%')
                        ->where('category', '=', 'Fixed Term')
                        ->where('time_type', '=', 'Full Time')
                        ->groupBy('demography_id')
                        ->get();
                $data[$key]['total'] = $demography->count();
                $data[$key]['period'] = $i;
                $key++;
            }
        }
        return json_encode($data);
    }
    public static function getDiversityData($from, $to) {
       echo "$from....$to" ; exit;
    }
}
