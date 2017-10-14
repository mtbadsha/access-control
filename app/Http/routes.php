<?php
Route::get('/', 'WelcomeController@index');

Route::get('login',['middleware'=>'guest','uses'=>'AuthenticationController@login']);
Route::post('login','AuthenticationController@postLogin');
Route::get('logout',['middleware'=>'auth','uses'=>'AuthenticationController@logout']);
Route::get('change_password',['middleware'=>'auth','uses'=>'AuthenticationController@change_password']);
Route::get('ajaxpass',['middleware'=>'auth','uses'=>'AuthenticationController@ajaxpass']);
Route::post('post_change_password','AuthenticationController@post_change_password');


Route::get('users/create','UserManagementController@registration');
Route::post('registration','UserManagementController@postRegistration');
Route::get('users','UserManagementController@listOfUser');
Route::get('users/edit/{id}','UserManagementController@edit_user');
Route::post('edit_user','UserManagementController@edit_user2');
Route::get('users/password_edit/{id}','UserManagementController@reset_password');
Route::post('post_reset_password','UserManagementController@post_reset_password');

Route::get('menus/create','MenuController@create_menu');
Route::post('post_create_menu','MenuController@post_create_menu');
Route::get('menus','MenuController@listOFMenu');
Route::get('menus/edit/{id}','MenuController@edit_menu');
Route::post('edit_menu','MenuController@edit_menu2');

Route::get('roles/create','RoleController@create_role');
Route::post('post_create_role','RoleController@post_create_role');
Route::get('roles','RoleController@listOFRule');
Route::get('roles/edit/{id}','RoleController@edit_role');
Route::post('edit_role','RoleController@edit_role2');

Route::get('permission','RoleController@permission');
Route::post('post_permission','RoleController@post_permission');
Route::get('menu_assign_to_role_list','RoleController@menu_assign_to_role_list');
Route::get('edit_menu_assign_to_role/{id}','RoleController@edit_menu_assign_to_role');
Route::post('edit_menu_assign_to_role','RoleController@edit_menu_assign_to_role2');

Route::get('role_assign_to_user','RoleController@role_assign_to_user');
Route::post('post_role_to_user','RoleController@post_role_to_user');
Route::get('role_assign_to_user_list','RoleController@role_assign_to_user_list');
Route::get('role_assign_to_user_edit/{id}','RoleController@edit_role_assign_to_user');
Route::post('edit_role_assign_to_user','RoleController@edit_role_assign_to_user2');


Route::get('/ajax',function()
{
    $sub = \App\Role::all();
    return Response::json($sub);
});

Route::get('employees','EmployeeController@employees');
Route::get('employees/bulk_upload','EmployeeController@bulk_upload');
Route::post('employee/post_bulk_upload','EmployeeController@post_bulk_upload');
Route::get('employees/bulk_upload_new','EmployeeController@bulk_upload_new');
Route::post('employee/post_bulk_upload_new','EmployeeController@post_bulk_upload_new');

Route::get('employee_report/division','EmployeeReportController@division');
Route::post('post_search_division','EmployeeReportController@post_search_division');
Route::get('employee_report/department','EmployeeReportController@department');
Route::post('post_search_department','EmployeeReportController@post_search_department');
Route::get('employee_report/section','EmployeeReportController@section');
Route::post('post_search_section','EmployeeReportController@post_search_section');

Route::get('/ajaxdivision',function()
{
    $division = Input::get('division');
    $sub = \App\Organizations::where('parent_organization_name','=',$division)->get();
    return Response::json($sub);
});

Route::get('/ajaxdepartment',function()
{
    $department = Input::get('department');
    $sub = \App\Organizations::where('parent_organization_name','=',$department)->get();
    return Response::json($sub);
});

Route::get('notifications','NotificationController@notifications');
Route::get('notification/{id}','NotificationController@notification_individual');

Route::get('messages','MessageController@messages');
Route::get('message/{id}','MessageController@message_individual');

Route::get('demo/excelimport','DemoController@demoExcelImport');
Route::post('excel_test','DemoController@demoExcelImport2');
Route::get('demo/excelexport','DemoController@demoExcelExport');
Route::get('demo/pdfcreate','DemoController@demoPdfCreate');
# demo routs
Route::get('demo/graph','DemoController@demoGraph');


Route::get('employeetrending','DemographyController@getHeadcountTrending');
Route::post('employeetrending','DemographyController@postHeadcountTrending');
Route::get('diversityhiringvsternover','DemographyController@getDiversityHiringVsTernover');
Route::post('diversityhiringvsternover','DemographyController@postDiversityHiringVsTernover');
Route::get('forecastedheadcount','DemographyController@getForecastedHeadcount');
Route::post('forecastedheadcount','DemographyController@postForecastedHeadcount');


#Forecust data upload
Route::get('forcastdata','ForcastdataController@getIndex');
Route::get('forcastdata/new','ForcastdataController@getNew');
Route::post('forcastdata/new','ForcastdataController@postNew');

