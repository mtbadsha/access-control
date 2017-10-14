<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EmployeeReportController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function division() {
        $id_division = Session::get('id_division');
        $divisions = \App\Organizations::where('organization_type', '=', 'Division')->get();
        if ($id_division != null) {
            $employees = \App\Employee::where('division_id', '=', $id_division)->get();
            return view('employee_report.division')->with('divisions', $divisions)->with('employees', $employees);
        }
        return view('employee_report.division')->with('divisions', $divisions)->with('employees', null);
    }

    public function post_search_division() {
        $id_division = Input::get('division');
        return Redirect::to('employee_report/division')->with('id_division', $id_division);
    }

    public function department() {
        $id_department = Session::get('id_department');
        $divisions = \App\Organizations::where('organization_type', '=', 'Division')->get();
        if ($id_department != null) {
            $employees = \App\Employee::where('department_id', '=', $id_department)->get();
            return view('employee_report.department')->with('divisions', $divisions)->with('employees', $employees);
        }
        return view('employee_report.department')->with('divisions', $divisions)->with('employees', null);
    }

    public function post_search_department() {
        $id_department = Input::get('department');
        return Redirect::to('employee_report/department')->with('id_department', $id_department);
    }

    public function section() {
        $id_section = Session::get('id_section');
        $divisions = \App\Organizations::where('organization_type', '=', 'Division')->get();
        if ($id_section != null) {
            $employees = \App\Employee::where('section_id', '=', $id_section)->get();
            return view('employee_report.section')->with('divisions', $divisions)->with('employees', $employees);
        }
        return view('employee_report.section')->with('divisions', $divisions)->with('employees', null);
    }

    public function post_search_section() {
        $id_section = Input::get('section');
        return Redirect::to('employee_report/section')->with('id_section', $id_section);
    }

}
