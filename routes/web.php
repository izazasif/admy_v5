<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require_once 'web.admin.php';

Route::get('/','HomeController@index')->name('home');
Route::get('/web/api','HomeController@webAPI')->name('web-api');
Route::get('/phpinfo','HomeController@phpinfo');
Route::get('/contact','ContactUsController@contact')->name('contact');
Route::get('/analytics','ObdController@analytics')->name('analytics');
Route::get('/privacy','PrivacyPolicyController@index')->name('privacy');
Route::post('/contact/submit','ContactController@store')->name('contact.submit');

Route::group(['middleware' => 'CheckLogin'], function(){
    Route::get('/signin','LoginController@signin')->name('signin');
    Route::post('/signin/submit','LoginController@signinSubmit')->name('signin.submit');

    Route::get('/signup','LoginController@signup')->name('signup');
    Route::post('/signup/submit','LoginController@signupSubmit')->name('signup.submit');

    Route::get('/verify/{id}/{token}','LoginController@verify')->name('verify');
    Route::get('/reset/{id}/{token}','LoginController@reset')->name('reset');

    Route::get('/forgot_password','LoginController@forgot')->name('forgot');
    Route::post('/forgot_password/email/submit','LoginController@forgotEmailSubmit')->name('forgot.email.submit');
    Route::post('/forgot_password/pass/submit','LoginController@forgotPassSubmit')->name('forgot.password.submit');
});

Route::group(['middleware' => 'CheckLogout'], function(){
    Route::group(['middleware' => 'CheckUser'], function(){ 
        Route::get('/obd/invoice/{id}','PackController@invoicePdf')->name("obd.invoice");      
        Route::post('user/campaing/stat','Api\CampainController@smsCampaingStat')->name('sms.campaing.stat.user');
        Route::get('/campaing/stat','Portal\SMSController@campaingForUser')->name('sms.campaing.list.user');
        Route::get('/schedule/create','ScheduleController@create')->name('schedule.create');
        Route::post('/schedule/create/submit','ScheduleController@createSubmit')->name('schedule.create.submit');

        Route::get('/schedule/history','ScheduleController@history')->name('schedule.history');
        Route::post('/schedule/history','ScheduleController@history')->name('schedule.history');
        Route::get('/schedule/history/reset','ScheduleController@reset')->name('schedule.history.reset');

        Route::get('/schedule/report','ScheduleController@report')->name('schedule.report');
        Route::post('/schedule/report','ScheduleController@report')->name('schedule.report');
        Route::get('/schedule/report/reset','ScheduleController@resetReport')->name('schedule.report.reset');

        Route::get('/sms/schedule/create','Portal\SMSScheduleController@create')->name('sms.schedule.create');
        Route::post('sms/schedule/create/submit','Portal\SMSScheduleController@store')->name('sms.schedule.create.submit');

        Route::get('/pack/purchase','PackController@purchase')->name('pack.purchase');
        Route::get('/pack/purchase/{id}','PackController@purchaseSelect')->name('pack.purchase.select');

        Route::get('/pack/checkout/{id}','PackController@checkout')->name('pack.checkout');
        Route::get('/payment/create','PaymentController@paymentCreate')->name('payment.create');
        Route::get('/payment/execute','PaymentController@paymentExecute')->name('payment.execute');
        Route::get('/payment/success','PaymentController@paymentSuccess')->name('payment.success');
        Route::get('/payment/error/{code}','PaymentController@paymentError')->name('payment.error');

        Route::get('/payment/query','PaymentController@paymentQuery')->name('payment.query');
        Route::get('/payment/search','PaymentController@paymentSearch')->name('payment.search');

        Route::get('/pack/history','PackController@history')->name('pack.history');
        Route::post('/pack/history','PackController@history')->name('pack.history');
        Route::get('/pack/history/reset','PackController@reset')->name('pack.history.reset');

        Route::get('/ticket/create','TicketController@create')->name('ticket.create');
        Route::post('/ticket/store','TicketController@store')->name('ticket.store');
        Route::get('/ticket/list/self','TicketController@selfList')->name('ticket.list.self');
        Route::get('/ticket/self/edit/{id}','TicketController@selfEdit')->name('ticket.edit.self');
        Route::post('/ticket/self/update','TicketController@selfUpdate')->name('ticket.update.self');

        Route::get('/faq','PackController@faq')->name('faq');

        Route::get('/sms/purchase','Portal\SMSController@purchase')->name('sms.purchase');
        Route::get('/sms/purchase/{id}','Portal\SMSController@purchaseSelect')->name('sms.purchase.select');
        Route::get('/sms/checkout/{id}','Portal\SMSController@checkout')->name('sms.checkout');

        Route::get('sms/schedule/list/user','Portal\SMSScheduleController@listForUser')->name('sms.schedule.list.user');
        Route::get('sms/campaign/information/user/{id}','Portal\SMSController@campaignInformation')->name('sms.campaign.information.user');
        Route::get('/sms/push/purchase/history','Portal\SMSController@purchaseHistory')->name('sms.purchase.history');

        Route::get('/web/api/purchase','Portal\WebApiController@purchase')->name('web.api.purchase');
        Route::get('/web/api/checkout/{id}/{acquisition?}','Portal\WebApiController@checkout')->name('web.api.checkout');
        Route::post('/web/api/checkout/post','Portal\WebApiController@checkoutPost')->name('web.api.checkout.post');
        Route::get('/web/api/purchase/history','Portal\WebApiController@purchaseHistory')->name('web.api.purchase.history');


        Route::get('web/api/schedule/create','Portal\WebAPIScheduleController@create')->name('web.api.schedule.create');
        Route::post('web/api/schedule/create/submit','Portal\WebAPIScheduleController@store')->name('web.api.schedule.create.submit');
        Route::get('web/api/schedule/user/list','Portal\WebAPIScheduleController@userList')->name('web.api.schedule.list.user');

        //Bikash Api URL
//        Route::post('bikash/get-token', 'Portal\BikashController@getToken')->name('bkash-get-token');
    });
    //admin start
    Route::group(['middleware' => 'CheckAdmin'], function(){
              
        Route::get('/category/create','CategoryController@create')->name('category.create');
        Route::post('/category/store','CategoryController@store')->name('category.store');
        Route::get('/category/list','CategoryController@index')->name('category.list');
        Route::get('/category/edit/{id}','CategoryController@edit')->name('category.edit');
        Route::post('/category/update','CategoryController@update')->name('category.update');   
        
        Route::get('/admin/create','AdminController@create')->name('admin.create');
        Route::post('/admin/store','AdminController@store')->name('admin.store');
        Route::get('/admin/list','AdminController@index')->name('admin.list');
        Route::get('/admin/edit/{id}','AdminController@edit')->name('admin.edit');
        Route::post('/admin/update','AdminController@update')->name('admin.update');

        Route::get('/user/list','AdminController@userList')->name('user.list');
        Route::get('/user/list/update/active/{id}','AdminController@userUpdateActive')->name('user.list.update.active');
        Route::get('/user/list/update/inactive/{id}','AdminController@userUpdateInactive')->name('user.list.update.inactive');
        
        Route::get('/web/api/create','Portal\WebApiController@create')->name('web.api.create');
        Route::post('/web/api/store','Portal\WebApiController@store')->name('web.api.store');
        Route::get('/web/api/list','Portal\WebApiController@index')->name('web.api.list');
        Route::get('/web/api/edit/{id}','Portal\WebApiController@edit')->name('web.api.edit');
        Route::post('/web/api/update','Portal\WebApiController@update')->name('web.api.update');

        Route::get('web/api/schedule/delivered/{id}','Portal\WebAPIScheduleController@delivered')->name('web.api.schedule.delivered');
        Route::get('web/api/schedule/list','Portal\WebAPIScheduleController@list')->name('web.api.schedule.list');
        
        Route::get('/ticket/list','TicketController@index')->name('ticket.list');
        Route::get('/ticket/edit/{id}','TicketController@edit')->name('ticket.edit');
        Route::post('/ticket/update','TicketController@update')->name('ticket.update');
   
        Route::get('admin/user/report','Portal\ReportController@dailyUserReport')->name('admin.userreport');
        Route::get('admin/obd/report','Portal\ReportController@dailyObdReport')->name('admin.obdreport');
        Route::get('admin/sms/report','Portal\ReportController@dailySmsReport')->name('admin.smsreport');
        Route::get('admin/activity/log','Portal\ReportController@activityLog')->name('admin.logreport');
        //  Route::get('joycall/login','Api\CampainController@getUserKey')->name('joycall.login');

    });
    // OBD Manager
    Route::group(['middleware' => 'CheckOBDManager'], function(){
        Route::get('/clip/create','ClipController@create')->name('clip.create');
        Route::post('/clip/store','ClipController@store')->name('clip.store');        
        Route::get('/clip/edit/{id}','ClipController@edit')->name('clip.edit');
        Route::post('/clip/update','ClipController@update')->name('clip.update');
        Route::get('/schedule/reject/{id}','ScheduleController@reject')->name('obdSreject');
        Route::get('/pack/create','PackController@create')->name('pack.create');
        Route::post('/pack/store','PackController@store')->name('pack.store');        
        Route::get('/pack/edit/{id}','PackController@edit')->name('pack.edit');
        Route::post('/pack/update','PackController@update')->name('pack.update');        
        Route::post('/schedule/update','ScheduleController@update')->name('schedule.list.update');
    });
    // OBD Viewer
    Route::group(['middleware' => 'CheckOBDViewer'], function(){
        Route::get('/clip/list','ClipController@index')->name('clip.list');
        Route::get('/pack/list','PackController@index')->name('pack.list');
        Route::get('/schedule/list','ScheduleController@list')->name('schedule.list');
        Route::post('/schedule/list','ScheduleController@list')->name('schedule.list');
        Route::get('/schedule/list/reset','ScheduleController@resetList')->name('schedule.list.reset');

    });
    // SMS Manager
    Route::group(['middleware' => 'CheckSMSManager'], function(){
        Route::get('/sms/create','Portal\SMSController@create')->name('portal.sms.create');
        Route::post('/sms/store','Portal\SMSController@store')->name('portal.sms.store');        
        Route::get('/sms/edit/{id}','Portal\SMSController@edit')->name('portal.sms.edit');
        Route::post('/sms/update','Portal\SMSController@update')->name('portal.sms.update');
        Route::get('/sms/schedule/reject/{id}','Portal\SMSController@reject')->name('portal.sms.reject');

        Route::get('/sms/text/create','Portal\SMSTextController@create')->name('sms.text.create');
        Route::post('/sms/text/store','Portal\SMSTextController@store')->name('sms.text.store');        
        Route::get('/sms/text/edit/{id}','Portal\SMSTextController@edit')->name('sms.text.edit');
        Route::post('/sms/text/update','Portal\SMSTextController@update')->name('sms.text.update');

        Route::get('sms/campaign/start/{id}','Portal\SMSController@startCampaign')->name('sms.campaign.start');
          
    });
    // SMS Viewer
    Route::group(['middleware' => 'CheckSMSViewer'], function(){
        Route::get('/sms/list','Portal\SMSController@index')->name('portal.sms.list');
        Route::get('/sms/text/list','Portal\SMSTextController@index')->name('sms.text.list');
        Route::get('sms/schedule/list','Portal\SMSScheduleController@list')->name('sms.schedule.list');
        
        Route::get('sms/campaign/information/{id}','Portal\SMSController@campaignInformation')->name('sms.campaign.information');
        Route::post('admin/campaing/stat','Api\CampainController@smsCampaingStat')->name('sms.campaing.stat');
        Route::get('admin/campaing/stat-2','Api\CampainController@smsCampaingStat2')->name('sms.campaing.stat2');
        Route::get('admin/campaing/stat','Portal\SMSController@campaingForAdmin')->name('sms.campaing.list.admin');
    });      

});

Route::post('bikash/get-token', 'Portal\BikashController@getToken')->name('bkash-get-token');
Route::post('bkash/create-payment', 'Portal\BikashController@createPayment')->name('bkash-create-payment');
Route::post('bkash/execute-payment', 'Portal\BikashController@executePayment')->name('bkash-execute-payment');
Route::get('bkash/query-payment', 'Portal\BikashController@queryPayment')->name('bkash-query-payment');
Route::get('bkash/success/{payment_id}', 'Portal\BikashController@bkashSuccess')->name('bkash-success');
Route::get('bkash/error/{code}', 'Portal\BikashController@bkashError')->name('bkash-error');

Route::post('web/bikash/get-token', 'Portal\WebBikashController@getToken')->name('web-bkash-get-token');
Route::post('web/bkash/create-payment', 'Portal\WebBikashController@createPayment')->name('web-bkash-create-payment');
Route::post('web/bkash/execute-payment', 'Portal\WebBikashController@executePayment')->name('web-bkash-execute-payment');
Route::get('web/bkash/query-payment', 'Portal\WebBikashController@queryPayment')->name('web-bkash-query-payment');
Route::get('web/bkash/success/{payment_id}', 'Portal\WebBikashController@bkashSuccess')->name('web-bkash-success');
Route::get('web/bkash/error/{code}', 'Portal\WebBikashController@bkashError')->name('web-bkash-error');

Route::get('/logout','LoginController@logout')->name('logout');
