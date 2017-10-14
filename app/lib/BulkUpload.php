<?php
/**
 * Created by PhpStorm.
 * User: sohel.rana
 * Date: 12/17/2015
 * Time: 11:22 AM
 */

namespace App\lib;


class BulkUpload {

    public static function bulk_upload_new($filename)
    {
        $destinationPath = public_path().'/uploads/bulk_new';

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
            $employee->division_name = $data[19];
            $employee->department_id = $data[20];
            $employee->department_name = $data[21];
            $employee->section_id = $data[22];
            $employee->section_name = $data[23];
            $employee->subsection_id = $data[24];
            $employee->subsection_name = $data[25];
            $employee->unit_id = $data[26];
            $employee->unit_name = $data[27];
            $employee->subunit_id = $data[28];
            $employee->subunit_name = $data[29];
            $employee->grade = $data[30];
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
                    ->where('division_name','=',$data[19])->where('department_name','=',$data[21])->where('section_name','=',$data[23])->where('subsection_name','=',$data[25])->where('unit_name','=',$data[27])
                    ->where('grade','=',$data[30])->where('designation','=',$data[31])
                    ->where('supervisor_name','=',$data[43])->where('supervisor_email','=',$data[44])
                    ->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();

                if($if_change!=""&&$if_change!=null)
                {

                }
                else {
                    $input["division_name"]  = $data[19];
                    $input["department_name"]  = $data[21];
                    $input["section_name"]  = $data[23];
                    $input["subsection_name"]  = $data[25];
                    $input["unit_name"]  = $data[27];
                    $input["grade"]  = $data[30];
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
            $employee_demography->division_name =$data[19];
            $employee_demography->department_name = $data[21];
            $employee_demography->section_name = $data[23];
            $employee_demography->subsection_name =$data[25];
            $employee_demography->supervisor_global_id = $data[41];
            $employee_demography->supervisor_local_id =$data[42];
            $if_change_demography = \App\EmployeeDemography::where('demography_id','=',$employee_id->id)
                ->where('division_name','=',$data[19])->where('department_name','=',$data[21])->where('section_name','=',$data[23])
                ->where('subsection_name','=',$data[25])->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();
            if($if_change_demography!=null&& $if_change_demography!="")
            {

            }
            else
            {
                $input2["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemography::where('demography_id','=',$employee_id->id)->update($input2);
                $employee_demography->save();
            }


            ////////////////////Employee Demography Designation starts here
            $employee_demography_designation = new \App\EmployeeDemographyDesignation();
            $employee_demography_designation->employee_date = $date12;
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
                \App\EmployeeDemographyDesignation::where('demography_id','=',$employee_id->id)->update($input3);
                $employee_demography_designation->save();
            }

            ////////////////////Employee Demography Grade starts here
            $employee_demography_grade = new \App\EmployeeDemographyGrade();
            $employee_demography_grade->employee_date =  $date12;
            $employee_demography_grade->demography_id = $employee_id->id;
            $employee_demography_grade->joining_date = $date2;
            $employee_demography_grade->emp_grade = $data[30];

            $if_change_demography_grade = \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)
                ->where('emp_grade','=',$data[30])->first();
            if($if_change_demography_grade!=null&& $if_change_demography_grade!="")
            {

            }
            else
            {
                $input4["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)->update($input4);
                $employee_demography_grade->save();
            }

            ////////////////////Employee Demography Location starts here
            $employee_demography_location = new \App\EmployeeDemographyLocation();
            $employee_demography_location->employee_date = $date12;
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
                \App\EmployeeDemographyLocation::where('demography_id','=',$employee_id->id)->update($input5);
                $employee_demography_location->save();
            }
        }
        return Redirect::back();

    }

    public static function bulk_upload_old($filename)
    {
        $destinationPath = public_path().'/uploads/bulk_new';

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
            $employee->division_name = $data[19];
            $employee->department_id = $data[20];
            $employee->department_name = $data[21];
            $employee->section_id = $data[22];
            $employee->section_name = $data[23];
            $employee->subsection_id = $data[24];
            $employee->subsection_name = $data[25];
            $employee->unit_id = $data[26];
            $employee->unit_name = $data[27];
            $employee->subunit_id = $data[28];
            $employee->subunit_name = $data[29];
            $employee->grade = $data[30];
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
                    ->where('division_name','=',$data[19])->where('department_name','=',$data[21])->where('section_name','=',$data[23])->where('subsection_name','=',$data[25])->where('unit_name','=',$data[27])
                    ->where('grade','=',$data[30])->where('designation','=',$data[31])
                    ->where('supervisor_name','=',$data[43])->where('supervisor_email','=',$data[44])
                    ->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();

                if($if_change!=""&&$if_change!=null)
                {

                }
                else {
                    $input["division_name"]  = $data[19];
                    $input["department_name"]  = $data[21];
                    $input["section_name"]  = $data[23];
                    $input["subsection_name"]  = $data[25];
                    $input["unit_name"]  = $data[27];
                    $input["grade"]  = $data[30];
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
            $employee_demography->division_name =$data[19];
            $employee_demography->department_name = $data[21];
            $employee_demography->section_name = $data[23];
            $employee_demography->subsection_name =$data[25];
            $employee_demography->supervisor_global_id = $data[41];
            $employee_demography->supervisor_local_id =$data[42];
            $if_change_demography = \App\EmployeeDemography::where('demography_id','=',$employee_id->id)
                ->where('division_name','=',$data[19])->where('department_name','=',$data[21])->where('section_name','=',$data[23])
                ->where('subsection_name','=',$data[25])->where('supervisor_global_id','=',$data[41])->where('supervisor_local_id','=',$data[42])->first();
            if($if_change_demography!=null&& $if_change_demography!="")
            {

            }
            else
            {
                $input2["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemography::where('demography_id','=',$employee_id->id)->update($input2);
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
                \App\EmployeeDemographyDesignation::where('demography_id','=',$employee_id->id)->update($input3);
                $employee_demography_designation->save();
            }


            ////////////////////Employee Demography Grade starts here
            $employee_demography_grade = new \App\EmployeeDemographyGrade();
            $employee_demography_grade->employee_date_start =  $date12;
            $employee_demography_grade->demography_id = $employee_id->id;
            $employee_demography_grade->joining_date = $date2;
            $employee_demography_grade->emp_grade = $data[30];

            $if_change_demography_grade = \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)
                ->where('emp_grade','=',$data[30])->first();
            if($if_change_demography_grade!=null&& $if_change_demography_grade!="")
            {

            }
            else
            {
                $input4["employee_date_end"] =$previous_month_end;
                \App\EmployeeDemographyGrade::where('demography_id','=',$employee_id->id)->update($input4);
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
                \App\EmployeeDemographyLocation::where('demography_id','=',$employee_id->id)->update($input5);
                $employee_demography_location->save();
            }

        }

        return Redirect::back();
    }
}