<?php

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

Route::get('/getData','ClientController@test')->name('getData');

Route::get('/', function () {
    return view('index');
});

Route::get('/admin', function () {
    return view('pages.admin.login');
});

Route::post('/submitLogin','LoginController@loginpost');

Route::get('/dashboard',function(){
	return view('layouts.dashboard');
});

Route::get('/admin/dashboard',function(){
	return view('pages.admin.dashboard');
})->name('clientLogin');

Route::get('/client/dashboard',function(){
	return view('pages.client.dashboard');
})->name('clientDashboard');

Route::get('/login/request={request}', 'ClientController@getLink');
Route::get('/login',function(){
	return view('pages.client.login');
});
// Route::get('/clientDashboard',function(){
// 	return view('pages.client.dashboard');
// });

Route::get('/adminDashboard','DashboardController@dashboard');

Route::post('/createVPN','DashboardController@createAccount');

// Route::get('/viewData','DashboardController@viewData');

Route::get('/clientRegister',function(){
	return view('clientRegister');
});


Route::get('/ticket',function(){
	return view('pages.client.ticket');
});

Route::post('/generate','ClientController@generateLink');
Route::post('/register', 'ClientController@loginEmailLDAP');
Route::post('/registerClient','ClientController@registerClient');
Route::post('/registerVendor','ClientController@registerVendor');
Route::post('/addAddr','ClientController@addAddress');
// Route::post('/loginVpnClient','ClientDashboardController@loginEmailLDAPClient');
// Route::get('/clientDashboard','ClientDashboardController@loginEmailLDAPClient');

// Route::get('/clientDashboard',function(){
// 	return view('pages.client.clientDashboard');
// });

Route::post('/submitTicket','ClientController@registerTicketNumber');

Route::post('/relog','AdminController@reLogin');
Route::post('/vpn-account','AdminController@showAllVPN');

Route::get('/ipall','LoginController@getIP');


//TESTING
Route::get('/sendEmail', function(){
	return view('clearview');
});
Route::post('/sendEmail', 'SendEmailController@sendEmail');