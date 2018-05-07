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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'rest-api/v1'], function() {
   Route::get('/firebase', 'ApiController@index');
Route::post('/registration', 'ApiController@Registration');
Route::get('/users', 'ApiController@User'); 
Route::post('/add/question', 'ApiController@AddQusetion'); 
Route::get('/question', 'ApiController@Question'); 
Route::post('/add/faq', 'ApiController@AddFaq'); 
Route::get('/faq', 'ApiController@Faq');
Route::post('/add/about', 'ApiController@AddAbout'); 
Route::get('/about', 'ApiController@About');
Route::post('/login', 'ApiController@userLogin');
Route::post('/admin/login', 'ApiController@adminLogin');
Route::get('/profile', 'ApiController@Profile');
Route::post('/profile/update', 'ApiController@ProfileUpdate');
Route::post('/change/password', 'ApiController@ChangePassword');
Route::post('/add/enquery', 'ApiController@AddEnquery'); 
Route::post('/add/contact', 'ApiController@AddContact'); 
Route::get('/contact', 'ApiController@Contact');
Route::post('/update/faq', 'ApiController@FaqUpdate'); 
Route::post('/update/about', 'ApiController@UpdateAbout');
Route::post('/update/contact', 'ApiController@UpdateContact');
Route::get('/enquery', 'ApiController@Enquery'); 
Route::post('/add/question', 'ApiController@AddQuestion'); 
Route::post('/add/answer', 'ApiController@AddQuestion'); 
Route::post('/particular/question', 'ApiController@Particular');
Route::post('/add/answer', 'ApiController@AddAnswer');
Route::post('/user/answer', 'ApiController@UserAnswer');
Route::post('/fix/appoitment', 'ApiController@FixAppotiment');
Route::post('/your/appoitment', 'ApiController@YourAppoitment');
Route::get('/all/question', 'ApiController@AllQuestion');
Route::get('/all/answer', 'ApiController@AllAnswer');
Route::get('/all/appointment', 'ApiController@AllAppointment');
Route::get('/all/products', 'ApiController@AllProducts');
Route::post('/add/products', 'ApiController@AddProducts');

Route::post('/appointment/delete', 'ApiController@AppointmentDelete');
Route::post('/user/delete', 'ApiController@UserDelete');
Route::post('/faq/delete', 'ApiController@FaqDelete');
Route::post('/enquery/delete', 'ApiController@EnqueryDelete');
Route::post('/answer/delete', 'ApiController@AnswerDelete');
Route::post('/product/delete', 'ApiController@ProductDelete');
Route::get('admin/notification', 'ApiController@AdminNotification');
Route::get('user/notification', 'ApiController@UserNotification');
Route::post('add/user/notification', 'ApiController@UserAddNotification');
Route::post('add/admin/notification', 'ApiController@AdminAddNotification');

Route::get('all/notification', 'ApiController@AllNotification');
Route::post('add/notification', 'ApiController@AddNotification');
Route::post('notification/delete', 'ApiController@NotificationDelete');
Route::post('forget/pass', 'ApiController@ForgetPass');

});

  
                        
                           