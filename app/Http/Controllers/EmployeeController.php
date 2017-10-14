<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function employees() {
        $employees = \App\Employee::all();
        return View('employee.list_of_employee')->with('employees', $employees);
    }

    public function bulk_upload() {
        return View('employee.bulk_upload');
    }

    public function post_bulk_upload()
    {
        //return Input::all();
        // $date12 = Input::get('myDate');
        $file = Input::file('excel_file');
        $destinationPath = public_path().'/uploads/bulk_old';
        $filename        = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $exist = \App\ExcelFile::where('file_name','=',$filename)->first();
        if($exist=="")
        {
            $excel_file = new \App\ExcelFile();
            $excel_file->file_name = $filename;
            $excel_file->save();
        }

        $objPHPExcel = \PHPExcel_IOFactory::load($destinationPath.'/'.$filename);
        $loadData = $objPHPExcel->getActiveSheet()->toArray();
        unset($loadData[0]);
        $file_id = \App\ExcelFile::orderBy('id','DESC')->first();
        $date12 = Input::get('myDate');
        \App\EmployeeDemography::where('employee_date_start','=',$date12)->delete();
        \App\EmployeeDemographyDesignation::where('employee_date_start','=',$date12)->delete();
        \App\EmployeeDemographyLocation::where('employee_date_start','=',$date12)->delete();
        \App\EmployeeDemographyGrade::where('employee_date_start','=',$date12)->delete();

        foreach ($loadData as $data) {
            // dd($data);

            $employee = new \App\Employee();
            $employee->local_id = $data[0];
            $employee->file_id = $file_id->id;
            $employee->employee_name = $data[1];
            //  $employee->global_id = $r->last_name;
            // $employee->global_id = $r->first_name;
            $date = \App\lib\utility::dateConvert2($data[4]);
            $employee->date_of_birth = $date;
            if($data[5]=="F"||$data[5]=="Female")
            {
                $employee->gender = "Female";
            }
            else if($data[5]=="M"||$data[5]=="Male")
            {
                $employee->gender = "Male";
            }
            $employee->blood_group = $data[6];
            $employee->is_active = $data[7];
            $employee->category = $data[8];
            $employee->time_type = $data[9];
            // $employee->global_id = $r->international_assignee;
            $employee->father_name = $data[11];
            $date2 = \App\lib\utility::dateConvert2($data[12]);
            $employee->date_of_joining = $date2;
            $date3 = \App\lib\utility::dateConvert2($data[13]);
            $employee->orginal_hire_date = $date3;
            // $employee->global_id = $r->contract_start_date;
            //$employee->global_id = $r->contract_end_date;
            //$employee->global_id = $r->termination_date;
            //$employee->global_id = $r->confirmation_date;
            $employee->division_id = $data[18];
            $division_name = str_replace('BD-Div-', '', $data[19]);
            $employee->division_name = $division_name;
            $employee->department_id = $data[20];
            $department_name = str_replace('BD-Dept-', '', $data[21]);
            $employee->department_name = $department_name;
            $employee->section_id = $data[22];
            $section_name = str_replace('BD-Sect-', '', $data[23]);
            $employee->section_name = $section_name;
            $employee->subsection_id = $data[24];
            $sub_section_name2 = str_replace('BD-Subsection-', '', $data[25]);
            $sub_section_name = str_replace('BD-Subsect-', '', $sub_section_name2);
            $employee->subsection_name = $sub_section_name;
            $employee->unit_id = $data[26];
            $unit_name = str_replace('BD-Unit-', '', $data[27]);
            $employee->unit_name = $unit_name;
            $employee->subunit_id = $data[28];
            $sub_unit_name = str_replace('BD-Subunit-', '', $data[29]);
            $employee->subunit_name = $sub_unit_name;
            $grade = str_replace('BD Band ', '', $data[30]);
            $employee->grade = $grade;
            $employee->designation = $data[31];
            $employee->email = $data[32];
//                $employee->global_id = $r->location_code;
//                $employee->global_id = $r->location_name;
//                $employee->global_id = $r->zone_code;
//                $employee->global_id = $r->zone_name;
//                $employee->global_id = $r->marital_status;
            $employee->mobile_number = $data[38];
//                $employee->global_id = $r->nationality;
//                $employee->global_id = $r->religion;
            $employee->supervisor_global_id = $data[41];
            $employee->supervisor_local_id = $data[42];
            $employee->supervisor_name = $data[43];
            $employee->supervisor_email = $data[44];
//                $employee->global_id = $r->sup_mobile;
//                $employee->global_id = $r->promotion_date;
            $employee->supervisor_grade = $data[47];
//                $employee->global_id = $r->years_of_experience;
//                $employee->global_id = $r->original_date_of_hire;
//                $employee->global_id = $r->latest_effective_start_date;
            $employee->global_id = $data[51];
            $exist = \App\Employee::where('global_id','=',$data[51])->where('local_id','=',$data[0])->first();

            if($exist!=""&&$exist!=null)
            {
                $if_change = \App\Employee::where('global_id','=',$data[51])->where('local_id','=',$data[0])
                    ->where('division_name','=',$division_name)->where('department_name','=',$department_name)->where('section_name','=',$section_name)->where('subsection_name','=',$sub_section_name)->where('unit_name','=',$unit_name)
                    ->where('grade','=',$grade)->where('designation','=',$data[31])
                    ->where('supervisor_name','=',$data[43])->where('supervisor_email','=',$data[44])
                    ->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();

                if($if_change!=""&&$if_change!=null)
                {

                }
                else {
                    $input["division_name"]  = $division_name;
                    $input["department_name"]  = $department_name;
                    $input["section_name"]  = $section_name;
                    $input["subsection_name"]  = $sub_section_name;
                    $input["unit_name"]  = $unit_name;
                    $input["grade"]  = $grade;
                    $input["designation"]  = $data[31];
                    $input["supervisor_global_id"]  = $data[41];
                    $input["supervisor_local_id"]  = $data[42];
                    $input["supervisor_name"]  = $data[43];
                    $input["supervisor_email"]  = $data[44];
                    \App\Employee::where('global_id','=',$data[51])->where('local_id','=',$data[0])->update($input);

                }
            }
            else{
                $employee->save();
            }


            $previous_month_end = \App\lib\utility::dateConverttoPreviousMonth($date12);
            $employee_id  = \App\Employee::where('local_id','=',$data[0])->where('global_id','=',$data[51])->orderBy('id','DESC')->first();

            ////////////////////Employee Demography starts here
            $employee_demography = new \App\EmployeeDemography();
            $employee_demography->employee_date_start = $date12;
            $employee_demography->demography_id = $employee_id->id;
            $employee_demography->date_of_birth = $date;
            if($data[5]=="F"||$data[5]=="Female")
            {
                $employee_demography->gender = "Female";
            }
            else if($data[5]=="M"||$data[5]=="Male")
            {
                $employee_demography->gender = "Male";
            }
            $employee_demography->blood_group = $data[6];
            $employee_demography->joining_date =$date2;
            $employee_demography->category = $data[8];
            $employee_demography->time_type = $data[9];
            $employee_demography->division_name =$division_name;
            $employee_demography->department_name = $department_name;
            $employee_demography->section_name = $section_name;
            $employee_demography->subsection_name =$sub_section_name;
            $employee_demography->supervisor_global_id = $data[41];
            $employee_demography->supervisor_local_id =$data[42];
            $if_change_demography = \App\EmployeeDemography::where('demography_id','=',$employee_id->id)
                ->where('division_name','=',$division_name)->where('department_name','=',$department_name)->where('section_name','=',$section_name)
                ->where('subsection_name','=',$sub_section_name)->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();
            if($if_change_demography!=null&& $if_change_demography!="")
            {

            }
            else
            {
                $input2["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemography::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input2);
                $employee_demography->save();
            }


            ////////////////////Employee Demography Designation starts here
            $employee_demography_designation = new \App\EmployeeDemographyDesignation();
            $employee_demography_designation->employee_date_start = $date12;
            $employee_demography_designation->demography_id = $employee_id->id;
            $employee_demography_designation->emp_designation = $data[31];

            $if_change_demography_designation = \App\EmployeeDemographyDesignation::where('demography_id','=',$employee_id->id)
                ->where('emp_designation','=',$data[31])->first();
            if($if_change_demography_designation!=null&& $if_change_demography_designation!="")
            {

            }
            else
            {
                $input3["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyDesignation::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input3);
                $employee_demography_designation->save();
            }


            ////////////////////Employee Demography Grade starts here
            $employee_demography_grade = new \App\EmployeeDemographyGrade();
            $employee_demography_grade->employee_date_start =  $date12;
            $employee_demography_grade->demography_id = $employee_id->id;
            $employee_demography_grade->joining_date = $date2;
            $employee_demography_grade->emp_grade = $grade;

            $if_change_demography_grade = \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)
                ->where('emp_grade','=',$grade)->first();
            if($if_change_demography_grade!=null&& $if_change_demography_grade!="")
            {

            }
            else
            {
                $input4["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input4);
                $employee_demography_grade->save();
            }


            ////////////////////Employee Demography Location starts here
            $employee_demography_location = new \App\EmployeeDemographyLocation();
            $employee_demography_location->employee_date_start = $date12;
            $employee_demography_location->demography_id = $employee_id->id;
            $employee_demography_location->location_code = $data[33];
            $employee_demography_location->location_name = $data[34];
            $employee_demography_location->zone_code = $data[35];
            $employee_demography_location->zone_name = $data[36];

            $if_change_demography_location = \App\EmployeeDemographyLocation::where('demography_id','=',$employee_id->id)
                ->where('location_code','=',$data[33])->where('location_name','=',$data[34])
                ->where('zone_code','=',$data[35])->where('zone_name','=',$data[36])->first();
            if($if_change_demography_location!=null&& $if_change_demography_location!="")
            {

            }
            else
            {
                $input5["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyLocation::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input5);
                $employee_demography_location->save();
            }

        }
        unlink($destinationPath.'/'.$filename);
        return Redirect::to('/employees');

    }

    public function bulk_upload_new()
    {
        return View('employee.bulk_upload_new');
    }

    public function post_bulk_upload_new()
    {
        //return Input::all();
        // $date12 = Input::get('myDate');
        $file = Input::file('excel_file');
        $destinationPath = public_path().'/uploads/bulk_new';
        $filename        = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $exist = \App\ExcelFile::where('file_name','=',$filename)->first();
        if($exist=="")
        {
            $excel_file = new \App\ExcelFile();
            $excel_file->file_name = $filename;
            $excel_file->save();
        }

        $objPHPExcel = \PHPExcel_IOFactory::load($destinationPath.'/'.$filename);
        $loadData = $objPHPExcel->getActiveSheet()->toArray();
        unset($loadData[0]);
        $file_id = \App\ExcelFile::where('file_name','=',$filename)->first();
        $date12 = Input::get('myDate');
        \App\EmployeeDemography::where('employee_date_start','=',$date12)->delete();
        \App\EmployeeDemographyDesignation::where('employee_date_start','=',$date12)->delete();
        \App\EmployeeDemographyLocation::where('employee_date_start','=',$date12)->delete();
        \App\EmployeeDemographyGrade::where('employee_date_start','=',$date12)->delete();

        foreach ($loadData as $data) {
            // dd($data);

            $employee = new \App\Employee();
            $employee->local_id = $data[0];
            $employee->file_id = $file_id->id;
            $employee->employee_name = $data[1];
            //  $employee->global_id = $r->last_name;
            // $employee->global_id = $r->first_name;
            $date = \App\lib\utility::dateConvert3($data[4]);
            $employee->date_of_birth = $date;
            if($data[5]=="F"||$data[5]=="Female")
            {
                $employee->gender = "Female";
            }
            else if($data[5]=="M"||$data[5]=="Male")
            {
                $employee->gender = "Male";
            }
            $employee->blood_group = $data[6];
            $employee->is_active = $data[7];
            $employee->category = $data[8];
            $employee->time_type = $data[9];
            // $employee->global_id = $r->international_assignee;
            $employee->father_name = $data[11];
            $date2 = \App\lib\utility::dateConvert3($data[12]);
            $employee->date_of_joining = $date2;
            $date3 = \App\lib\utility::dateConvert3($data[13]);
            $employee->orginal_hire_date = $date3;
            // $employee->global_id = $r->contract_start_date;
            //$employee->global_id = $r->contract_end_date;
            //$employee->global_id = $r->termination_date;
            //$employee->global_id = $r->confirmation_date;
            $employee->division_id = $data[18];
            $division_name = str_replace('BD-Div-', '', $data[19]);
            $employee->division_name = $division_name;
            $employee->department_id = $data[20];
            $department_name = str_replace('BD-Dept-', '', $data[21]);
            $employee->department_name = $department_name;
            $employee->section_id = $data[22];
            $section_name = str_replace('BD-Sect-', '', $data[23]);
            $employee->section_name = $section_name;
            $employee->subsection_id = $data[24];
            $sub_section_name = str_replace('BD-Subsect-', '', $data[25]);
            $employee->subsection_name = $sub_section_name;
            $employee->unit_id = $data[26];
            $unit_name = str_replace('BD-Unit-', '', $data[27]);
            $employee->unit_name = $unit_name;
            $employee->subunit_id = $data[28];
            $sub_unit_name = str_replace('BD-Subunit-', '', $data[29]);
            $employee->subunit_name = $sub_unit_name;
            $grade = str_replace('BD Band ', '', $data[30]);
            $employee->grade = $grade;
            $employee->designation = $data[31];
            $employee->email = $data[32];
//                $employee->global_id = $r->location_code;
//                $employee->global_id = $r->location_name;
//                $employee->global_id = $r->zone_code;
//                $employee->global_id = $r->zone_name;
//                $employee->global_id = $r->marital_status;
            $employee->mobile_number = $data[38];
//                $employee->global_id = $r->nationality;
//                $employee->global_id = $r->religion;
            $employee->supervisor_global_id = $data[41];
            $employee->supervisor_local_id = $data[42];
            $employee->supervisor_name = $data[43];
            $employee->supervisor_email = $data[44];
//                $employee->global_id = $r->sup_mobile;
//                $employee->global_id = $r->promotion_date;
            $employee->supervisor_grade = $data[47];
//                $employee->global_id = $r->years_of_experience;
//                $employee->global_id = $r->original_date_of_hire;
//                $employee->global_id = $r->latest_effective_start_date;
            $employee->global_id = $data[51];
            $exist = \App\Employee::where('global_id','=',$data[51])->where('local_id','=',$data[0])->first();
            if($exist!=""&&$exist!=null)
            {
                $if_change = \App\Employee::where('global_id','=',$data[51])->where('local_id','=',$data[0])
                    ->where('division_name','=',$division_name)->where('department_name','=',$department_name)->where('section_name','=',$section_name)->where('subsection_name','=',$sub_section_name)->where('unit_name','=',$unit_name)
                    ->where('grade','=',$grade)->where('designation','=',$data[31])
                    ->where('supervisor_name','=',$data[43])->where('supervisor_email','=',$data[44])
                    ->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();

                if($if_change!=""&&$if_change!=null)
                {

                }
                else {
                    $input["division_name"]  = $division_name;
                    $input["department_name"]  = $department_name;
                    $input["section_name"]  = $section_name;
                    $input["subsection_name"]  = $sub_section_name;
                    $input["unit_name"]  = $unit_name;
                    $input["grade"]  = $grade;
                    $input["designation"]  = $data[31];
                    $input["supervisor_global_id"]  = $data[41];
                    $input["supervisor_local_id"]  = $data[42];
                    $input["supervisor_name"]  = $data[43];
                    $input["supervisor_email"]  = $data[44];
                    \App\Employee::where('global_id','=',$data[51])->where('local_id','=',$data[0])->update($input);

                }
            }
            else{
                $employee->save();
            }

            $previous_month_end = \App\lib\utility::dateConverttoPreviousMonth($date12);
            $employee_id  = \App\Employee::where('local_id','=',$data[0])->where('global_id','=',$data[51])->orderBy('id','DESC')->first();

            ////////////////////Employee Demography starts here
            $employee_demography = new \App\EmployeeDemography();
            $employee_demography->employee_date_start = $date12;
            $employee_demography->demography_id = $employee_id->id;
            $employee_demography->date_of_birth = $date;
            if($data[5]=="F"||$data[5]=="Female")
            {
                $employee_demography->gender = "Female";
            }
            else if($data[5]=="M"||$data[5]=="Male")
            {
                $employee_demography->gender = "Male";
            }
            $employee_demography->blood_group = $data[6];
            $employee_demography->joining_date =$date2;
            $employee_demography->category = $data[8];
            $employee_demography->time_type = $data[9];
            $employee_demography->division_name =$division_name;
            $employee_demography->department_name = $department_name;
            $employee_demography->section_name = $section_name;
            $employee_demography->subsection_name =$sub_section_name;
            $employee_demography->supervisor_global_id = $data[41];
            $employee_demography->supervisor_local_id =$data[42];
            $if_change_demography = \App\EmployeeDemography::where('demography_id','=',$employee_id->id)
                ->where('division_name','=',$division_name)->where('department_name','=',$department_name)->where('section_name','=',$section_name)
                ->where('subsection_name','=',$sub_section_name)->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();
            if($if_change_demography!=null&& $if_change_demography!="")
            {

            }
            else
            {
                $input2["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemography::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input2);
                $employee_demography->save();
            }


            ////////////////////Employee Demography Designation starts here
            $employee_demography_designation = new \App\EmployeeDemographyDesignation();
            $employee_demography_designation->employee_date_start = $date12;
            $employee_demography_designation->demography_id = $employee_id->id;
            $employee_demography_designation->emp_designation = $data[31];

            $if_change_demography_designation = \App\EmployeeDemographyDesignation::where('demography_id','=',$employee_id->id)
                ->where('emp_designation','=',$data[31])->first();
            if($if_change_demography_designation!=null&& $if_change_demography_designation!="")
            {

            }
            else
            {
                $input3["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyDesignation::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input3);
                $employee_demography_designation->save();
            }

            ////////////////////Employee Demography Grade starts here
            $employee_demography_grade = new \App\EmployeeDemographyGrade();
            $employee_demography_grade->employee_date_start =  $date12;
            $employee_demography_grade->demography_id = $employee_id->id;
            $employee_demography_grade->joining_date = $date2;
            $employee_demography_grade->emp_grade = $grade;

            $if_change_demography_grade = \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)
                ->where('emp_grade','=',$grade)->first();
            if($if_change_demography_grade!=null&& $if_change_demography_grade!="")
            {

            }
            else
            {
                $input4["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input4);
                $employee_demography_grade->save();
            }

            ////////////////////Employee Demography Location starts here
            $employee_demography_location = new \App\EmployeeDemographyLocation();
            $employee_demography_location->employee_date_start = $date12;
            $employee_demography_location->demography_id = $employee_id->id;
            $employee_demography_location->location_code = $data[33];
            $employee_demography_location->location_name = $data[34];
            $employee_demography_location->zone_code = $data[35];
            $employee_demography_location->zone_name = $data[36];

            $if_change_demography_location = \App\EmployeeDemographyLocation::where('demography_id','=',$employee_id->id)
                ->where('location_code','=',$data[33])->where('location_name','=',$data[34])
                ->where('zone_code','=',$data[35])->where('zone_name','=',$data[36])->first();
            if($if_change_demography_location!=null&& $if_change_demography_location!="")
            {

            }
            else
            {
                $input5["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyLocation::where('demography_id','=',$employee_id->id)->where('employee_date_end','=',null)->update($input5);
                $employee_demography_location->save();
            }
        }
        unlink($destinationPath.'/'.$filename);
        return Redirect::to('/employees');
    }


    public function post_bulk_upload2() {
        //return Input::all();
        // $date12 = Input::get('myDate');
        $file = Input::file('excel_file');
        $destinationPath = public_path() . '/uploads/';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $exist = \App\ExcelFile::where('file_name', '=', $filename)->first();
        if ($exist == "") {
            $excel_file = new \App\ExcelFile();
            $excel_file->file_name = $filename;
            $excel_file->save();
        }

        Excel::load($destinationPath . '/' . $filename, function($reader) {
            $results = $reader->get();
            $date12 = Input::get('myDate');
            \App\EmployeeDemography::where('employee_date', '=', $date12)->delete();
            \App\EmployeeDemographyDesignation::where('employee_date', '=', $date12)->delete();
            \App\EmployeeDemographyLocation::where('employee_date', '=', $date12)->delete();
            \App\EmployeeDemographyGrade::where('employee_date', '=', $date12)->delete();

            $file_id = \App\ExcelFile::orderBy('id', 'DESC')->first();
            foreach ($results as $r) {
                //  dd($r);
                $employee = new \App\Employee();
                $employee->local_id = $r->employee_no;
                $employee->file_id = $file_id->id;
                $employee->employee_name = $r->employee_name;
                //  $employee->global_id = $r->last_name;
                // $employee->global_id = $r->first_name;
                $employee->date_of_birth = $r->date_of_birth;
                $employee->gender = $r->gender;
                $employee->blood_group = $r->blood_group;
                $employee->is_active = $r->active;
                $employee->category = $r->category;
                $employee->time_type = $r->time_type;
                // $employee->global_id = $r->international_assignee;
                $employee->father_name = $r->father_name;
                $employee->date_of_joining = $r->date_of_joining;
                $employee->orginal_hire_date = $r->original_hire_date;
                // $employee->global_id = $r->contract_start_date;
                //$employee->global_id = $r->contract_end_date;
                //$employee->global_id = $r->termination_date;
                //$employee->global_id = $r->confirmation_date;
                $employee->division_id = $r->division_id;
                $employee->division_name = $r->division_name;
                $employee->department_id = $r->department_id;
                $employee->department_name = $r->department_name;
                $employee->section_id = $r->section_id;
                $employee->section_name = $r->section_name;
                $employee->subsection_id = $r->sub_section_id;
                $employee->subsection_name = $r->sub_section_name;
                $employee->unit_id = $r->unit_id;
                $employee->unit_name = $r->unit_name;
                $employee->subunit_id = $r->sub_unit_id;
                $employee->subunit_name = $r->sub_unit_name;
                $employee->grade = $r->grade;
                $employee->designation = $r->designation;
                $employee->email = $r->email_address;
//                $employee->global_id = $r->location_code;
//                $employee->global_id = $r->location_name;
//                $employee->global_id = $r->zone_code;
//                $employee->global_id = $r->zone_name;
//                $employee->global_id = $r->marital_status;
                $employee->mobile_number = $r->mobile_number;
//                $employee->global_id = $r->nationality;
//                $employee->global_id = $r->religion;
                $employee->supervisor_global_id = $r->supervisor_telenor_id;
                $employee->supervisor_local_id = $r->supervisor_local_id;
                $employee->supervisor_name = $r->supervisor_name;
                $employee->supervisor_email = $r->supervisor_email;
//                $employee->global_id = $r->sup_mobile;
//                $employee->global_id = $r->promotion_date;
                $employee->supervisor_grade = $r->sup_grade;
//                $employee->global_id = $r->years_of_experience;
//                $employee->global_id = $r->original_date_of_hire;
//                $employee->global_id = $r->latest_effective_start_date;
                $employee->global_id = $r->telenor_employee_id;
                $exist = \App\Employee::where('global_id', '=', $r->telenor_employee_id)->first();
                if ($exist != "" && $exist != null) {
                    
                } else {
                    $employee->save();
                }


                ////////////////////Employee Demography starts here

                $employee_demography = new \App\EmployeeDemography();
                $employee_demography->employee_date = $date12;
                $employee_demography->local_id = $r->employee_no;
                $employee_demography->global_id = $r->telenor_employee_id;
                $employee_demography->date_of_birth = $r->date_of_birth;
                $employee_demography->gender = $r->gender;
                $employee_demography->blood_group = $r->blood_group;
                $employee_demography->joining_date = $r->date_of_joining;
                $employee_demography->category = $r->category;
                $employee_demography->time_type = $r->time_type;
                $employee_demography->division_name = $r->division_name;
                $employee_demography->department_name = $r->department_name;
                $employee_demography->section_name = $r->section_name;
                $employee_demography->subsection_name = $r->sub_section_name;
                $employee_demography->supervisor_global_id = $r->supervisor_telenor_id;
                $employee_demography->supervisor_local_id = $r->supervisor_local_id;
                $employee_demography->save();

                $demography_latest = \App\EmployeeDemography::orderBy('id', 'DESC')->first();

                ////////////////////Employee Demography Designation starts here
                $employee_demography_designation = new \App\EmployeeDemographyDesignation();
                $employee_demography_designation->employee_date = $date12;
                $employee_demography_designation->demography_id = $demography_latest->id;
                $employee_demography_designation->emp_designation = $r->designation;
                $employee_demography_designation->save();

                ////////////////////Employee Demography Grade starts here
                $employee_demography_grade = new \App\EmployeeDemographyGrade();
                $employee_demography_grade->employee_date = $date12;
                $employee_demography_grade->demography_id = $demography_latest->id;
                $employee_demography_grade->joining_date = $r->date_of_joining;
                $employee_demography_grade->emp_grade = $r->grade;
                $employee_demography_grade->save();

                ////////////////////Employee Demography Location starts here
                $employee_demography_location = new \App\EmployeeDemographyLocation();
                $employee_demography_location->employee_date = $date12;
                $employee_demography_location->demography_id = $demography_latest->id;
                $employee_demography_location->location_code = $r->location_code;
                $employee_demography_location->location_name = $r->location_name;
                $employee_demography_location->zone_code = $r->zone_code;
                $employee_demography_location->zone_name = $r->zone_name;
                $employee_demography_location->save();
            }
        })->get();

        return Redirect::to('/employees');
    }

}
