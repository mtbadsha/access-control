<?php namespace App\Http\Controllers;

//use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Vsmoraes\Pdf\Pdf;

class DemoController extends Controller {

    private $pdf;

    public function __construct(Pdf $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function demoExcelImport() {
        return View('demo.excel_test');
    }

    public function demoExcelImport2()
    {
        $file = Input::file('excel_file');
        $destinationPath = public_path().'/uploads/';
        $filename        = str_random(6) . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);

        Excel::load($destinationPath.'/'.$filename, function($reader) {
            $results = $reader->get();
            foreach($results as $r)
            {
                // echo $r->name.'<br/>';
                $excel_test = new \App\ExcelTest();
                $myArray = explode(', ', $r->name);
                if(count($myArray)==1)
                {
                    $excel_test->name = $myArray[0];
                }
                if(count($myArray)==2)
                {
                    $excel_test->name = $myArray[0];
                    $excel_test->address = $myArray[1];
                }

                $excel_test->roll = $r->roll;
                $excel_test->save();
            }

        })->get();

        return Redirect::back();
    }
    public function demoExcelExport() {

        Excel::create('Hi GP',function($excel)
        {
            $excel->sheet('SheetName',function($sheet)
            {
                $data = [];
                array_push($data,array('kevin','arnold'));
                $sheet->fromArray($data,null,'A1',false,false);
            });
        })->download('xlsx');
    }

    public function demoPdfCreate() {

        $data['name'] = "Faysal kabir";
        $data['role'] = "admin";
        $html = view('demo.pdf')->with('data',$data)->render();

        return $this->pdf->load($html)->filename('ff.pdf')->show();
    }

    public function demoGraph() {
        return view('demo.graph');
    }

}
