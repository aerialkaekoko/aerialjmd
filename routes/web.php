<?php
Route::redirect('/', '/admin');
Route::post('register/media', 'RegisterController@storeMedia')->name('regiser.storeMedia');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);


Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('user-alerts/read', 'UserAlertsController@read');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');
    

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::get('profile', 'UsersController@profile');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('profile', 'UsersController@update_avatar');
    Route::get('permissions/get_by_role/{id}', 'UsersController@get_by_role');

    //Member Register
    Route::get('register1','MemberRegisterController@createRegister1')->name('register1');
    Route::post('register1','MemberRegisterController@PostCreateRegister1');
    Route::get('register2','MemberRegisterController@createRegister2')->name('register2');
    Route::post('register2','MemberRegisterController@PostCreateRegister2');
    Route::get('register3','MemberRegisterController@createRegister3')->name('register3');
    Route::post('register3','MemberRegisterController@PostCreateRegister3');
    Route::post('register/storeMedia','MemberRegisterController@storeMedia')->name('register.storeMedia');

    // Members
    Route::resource('members', 'MembersController');
    Route::get('/{user_id}/old_medical_info', 'MembersController@old_medical_info')->name('members.old_medical_info');
    Route::post('/{user_id}/old_medical_info_update', 'MembersController@old_medical_info_update')->name('members.old_medical_info_update');
    Route::delete('members/destroy', 'MembersController@massDestroy')->name('members.massDestroy');
    Route::post('members/media', 'MembersController@storeMedia')->name('members.storeMedia');
    Route::get('member/templateone/{id}','MembersController@claimtemplateone');
    Route::get('member/templatetwo/{id}','MembersController@claimtemplatetwo');
    Route::get('member/templatethree/{id}','MembersController@claimtemplatethree');
    Route::get('member/templatefour/{id}','MembersController@claimtemplatefour');
    Route::get('member/templatefive/{id}','MembersController@claimtemplatefive');
    Route::get('member/templatesix/{id}','MembersController@claimtemplatesix');
    Route::get('member/templateseven/{id}','MembersController@claimtemplateseven');
    Route::get('member/templateeight/{id}','MembersController@claimtemplateeight');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::post('user-alerts/media', 'UserAlertsController@storeMedia')->name('user-alerts.storeMedia');
    Route::resource('user-alerts', 'UserAlertsController');

    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');

    // news
    Route::delete('news/destroy', 'NewsController@massDestroy')->name('news.massDestroy');
    Route::post('news/media', 'NewsController@storeMedia')->name('news.storeMedia');
    Route::post('news/parse-csv-import', 'NewsController@parseCsvImport')->name('news.parseCsvImport');
    Route::post('news/process-csv-import', 'NewsController@processCsvImport')->name('news.processCsvImport');
    Route::resource('news', 'NewsController');

    // FileShare
    Route::view('/fileshare', 'filemanager');
    
    // Hospitals
    Route::delete('hospitals/destroy', 'HospitalController@massDestroy')->name('hospitals.massDestroy');
    Route::post('hospitals/media', 'HospitalController@storeMedia')->name('hospitals.storeMedia');
    Route::resource('hospitals', 'HospitalController');

    //Exchange
    Route::delete('exchanges/destroy', 'ExchangeController@massDestroy')->name('exchanges.massDestroy');
    Route::post('exchanges/media', 'ExchangeController@storeMedia')->name('exchanges.storeMedia');
    Route::resource('exchanges', 'ExchangeController');

    // Hospitals
    Route::delete('invoice_descriptions/destroy', 'InvoiceDescriptionController@massDestroy')->name('invoice_descriptions.massDestroy');
    Route::post('invoice_descriptions/media', 'InvoiceDescriptionController@storeMedia')->name('invoice_descriptions.storeMedia');
    Route::resource('invoice_descriptions', 'InvoiceDescriptionController');

    //Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::post('expenses/media', 'ExpenseController@storeMedia')->name('expenses.storeMedia');
    Route::resource('expenses', 'ExpenseController');

    // Assistances
    Route::delete('assistances/destroy', 'AssistanceController@massDestroy')->name('assistances.massDestroy');
    Route::resource('assistances', 'AssistanceController');

    // Insurances
    Route::delete('insurances/destroy', 'InsuranceController@massDestroy')->name('insurances.massDestroy');
    Route::resource('insurances', 'InsuranceController');
    Route::post('insurances/media', 'InsuranceController@storeMedia')->name('insurances.storeMedia');

    // User Insurances
    Route::delete('user-insurances/destroy', 'UserInsuranceController@massDestroy')->name('user-insurances.massDestroy');
    // Route::resource('user-insurances', 'UserInsuranceController');
    Route::get('/get_insurances/{id}', 'UserInsuranceController@get_insurance');
    Route::get('/{user_id}/user-insurances','UserInsuranceController@index')->name('user-insurances.index');
    Route::get('/{user_id}/user-insurances/create','UserInsuranceController@create')->name('user-insurances.create');
    Route::post('/{user_id}/user-insurances/store','UserInsuranceController@store')->name('user-insurances.store');
    Route::get('/{user_id}/user-insurances/{id}','UserInsuranceController@show')->name('user-insurances.show');
    Route::get('/{user_id}/user-insurances/edit/{id}','UserInsuranceController@edit')->name('user-insurances.edit');
    Route::put('/{user_id}/user-insurances/{id}','UserInsuranceController@update')->name('user-insurances.update');
    Route::delete('/{user_id}/user-insurances/{id}','UserInsuranceController@destroy')->name('user-insurances.destroy');

    // Personal Medical Information
    Route::delete('personal_informations/destroy', 'PersonalInformationController@massDestroy')->name('personal_informations.massDestroy');
    Route::get('/{user_id}/personal_informations','PersonalInformationController@index')->name('personal_informations.index');
    Route::get('/{user_id}/personal_informations/detail_list/{id}','PersonalInformationController@detail_list')->name('personal_informations.detail_list');
    Route::get('/{user_id}/personal_informations/create','PersonalInformationController@create')->name('personal_informations.create');
    Route::post('/{user_id}/personal_informations/store','PersonalInformationController@store')->name('personal_informations.store');
    Route::get('/{user_id}/personal_informations/{id}','PersonalInformationController@show')->name('personal_informations.show');
    Route::get('/{user_id}/personal_informations/edit/{id}','PersonalInformationController@edit')->name('personal_informations.edit');
    Route::put('/{user_id}/personal_informations/{id}','PersonalInformationController@update')->name('personal_informations.update');
    Route::delete('/{user_id}/personal_informations/{id}','PersonalInformationController@destroy')->name('personal_informations.destroy');
    Route::get('/get_assistances/{insurance_id}','PersonalInformationController@get_assistances');
    Route::post('personal_informations/media', 'PersonalInformationController@storeMedia')->name('personal_informations.storeMedia');   

    // Invoices
    Route::get('invoices', 'InvoicesController@index')->name('invoices.index');
    Route::get('invoices/createlist', 'InvoicesController@createlist')->name('invoices.createlist');
    Route::get('invoices/create1', 'InvoicesController@createForm1')->name('invoices.createform1');
    Route::post('invoices/store1', 'InvoicesController@storeForm1')->name('invoices.storeform1');
    Route::get('invoices/editform1/{id}', 'InvoicesController@editForm1')->name('invoices.editform1');
    Route::post('invoices/updateform1/{id}', 'InvoicesController@updateForm1')->name('invoices.updateform1');
     Route::delete('invoices/deleteform1/{id}', 'InvoicesController@deleteform1')->name('invoices.deleteform1');
    
    
    Route::get('invoices/create2', 'InvoicesController@createForm2')->name('invoices.createform2');
    Route::post('invoices/store2', 'InvoicesController@storeForm2')->name('invoices.storeform2');
    Route::get('invoices/editform2/{invoicecode}', 'InvoicesController@editForm2')->name('invoices.editform2');
    Route::get('invoices/show2/{invoicecode}', 'InvoicesController@show2')->name('invoices.show2');
    Route::post('invoices/updateform2/{id}', 'InvoicesController@updateForm2')->name('invoices.updateform2');
    Route::delete('invoices/deleteform2/{id}', 'InvoicesController@deleteform2')->name('invoices.deleteform2');

    Route::post('/multi_update','InvoicesController@multi_update')->name('multi_update');
    Route::get('autocomplete', 'InvoicesController@autocomplete')->name('autocomplete');
    Route::get('invoices/deleteItem/{id}', 'InvoicesController@deleteItem')->name('deleteitem');


    Route::get('invoices/{id}', 'InvoicesController@show1')->name('invoices.show1');
    Route::get('invoices/{id}/editform1', 'InvoicesController@editForm1')->name('invoices.editform1');
    Route::delete('invoices/{id}', 'InvoicesController@destroy')->name('invoices.destroy');
    Route::get('/get_user_insurance/{id}', 'InvoicesController@get_user_insurance');
    Route::get('/get_medical_info/{id}', 'InvoicesController@get_medical_info');
    Route::get('/delete_expense/{id}', 'InvoicesController@delete_expense');
    Route::get('/invoices/downloadpdf/{id}','InvoicesController@downloadpdf');
    Route::post('/summary_preview','InvoicesController@summary_preview')->name('summary_preview');
    Route::post('/summary_download','InvoicesController@summary_download')->name('summary_download');

    // Doctors
    Route::delete('doctors/destroy', 'DoctorController@massDestroy')->name('doctors.massDestroy');
    Route::post('doctors/media', 'DoctorController@storeMedia')->name('doctors.storeMedia');
    Route::resource('doctors', 'DoctorController');

    // Medicals
    Route::delete('medicals/destroy', 'MedicalController@massDestroy')->name('medicals.massDestroy');
    Route::post('medicals/media', 'MedicalController@storeMedia')->name('medicals.storeMedia');
    Route::resource('medicals', 'MedicalController');
    
    // Medicals
    Route::delete('medical_informations/destroy', 'MedicalInformationController@massDestroy')->name('medical_informations.massDestroy');
    Route::get('/{user_id}/medical_informations','MedicalInformationController@index')->name('medical_informations.index');
    Route::get('/{user_id}/medical_informations/detail_list/{id}','MedicalInformationController@detail_list')->name('medical_informations.detail_list');
    Route::get('/{user_id}/medical_informations/create','MedicalInformationController@create')->name('medical_infomations.create');
    Route::post('/{user_id}/medical_informations/store','MedicalInformationController@store')->name('medical_informations.store');
    Route::get('/{user_id}/medical_informations/{id}','MedicalInformationController@show')->name('medical_informations.show');
    Route::get('/{user_id}/medical_informations/edit/{id}','MedicalInformationController@edit')->name('medical_informations.edit');
    Route::put('/{user_id}/medical_informations/{id}','MedicalInformationController@update')->name('medical_informations.update');
    Route::delete('/{user_id}/medical_informations/{id}','MedicalInformationController@destroy')->name('medical_informations.destroy');
    Route::get('/get_assistances/{insurance_id}','MedicalInformationController@get_assistances');
    Route::post('medical_informations/media', 'MedicalInformationController@storeMedia')->name('medical_informations.storeMedia');
    Route::get('/get_last_patient_state/{patient_id}/{disease_id}','MedicalInformationController@get_last_patient_state');
    Route::post('/services', 'MedicalInformationController@storeService')->name('storeService');
    Route::get('/{user_id}/{medical_info_id}/services/{service_id}', 'MedicalInformationController@deleteService')->name('deleteService');
    Route::put('/services/{id}', 'MedicalInformationController@updateService')->name('updateService');

    //Reports
    Route::get('invoice_reports','ReportController@invoice_reports')->name('invoice_reports');
    Route::get('invoice_reports_excel','ReportController@invoice_reports_excel')->name('invoice_reports_excel');
    Route::get('patient_reports','ReportController@patient_reports')->name('patient_reports');
    Route::post('patient_reports/change_kb/{id}','ReportController@change_kb')->name('change_kb');
    Route::post('import','ReportController@import')->name('import');
     Route::get('patient_reports_excel','ReportController@patient_reports_excel')->name('patient_reports_excel');
     Route::get('summary_detail_excel','ReportController@summary_detail_excel')->name('summary_detail_excel');
     Route::post('summary_reports_excel','ReportController@summary_reports_excel')->name('summary_reports_excel');

    //Profit Reports
    Route::get('profit_reports','ReportController@profit_reports')->name('profit_reports');
    Route::get('profit_reports_excel','ReportController@profit_reports_excel')->name('profit_reports_excel');
    //Yearly Profit Reports
    Route::get('yearly_profit_reports','ReportController@yearly_profit_reports')->name('yearly_profit_reports');
    Route::get('yearly_profit_reports_excel','ReportController@yearly_profit_reports_excel')->name('yearly_profit_reports_excel');

    //fullcalender
    Route::get('fullcalendar','FullCalendarController@index');
    Route::post('fullcalendar/create','FullCalendarController@create');
    Route::post('fullcalendar/update','FullCalendarController@update');
    Route::post('fullcalendar/delete','FullCalendarController@destroy');

     // Memberships
    Route::delete('memberships/destroy', 'MembershipController@massDestroy')->name('memberships.massDestroy');
    Route::resource('memberships', 'MembershipController');

    // Local Insurances
    Route::delete('local-insurances/destroy', 'LocalInsuranceController@massDestroy')->name('local-insurances.massDestroy');
    Route::resource('local-insurances', 'LocalInsuranceController');

    // Departments
     Route::delete('departments/destroy', 'DepartmentController@massDestroy')->name('departments.massDestroy');
     Route::resource('departments', 'DepartmentController');     
     
});