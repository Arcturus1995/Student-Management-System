<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UserController;

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

// types of routes

// Route::get()
// Route::post()
// Route::put()
// Route::delete()
// Route::options()

// Route::match(['get','post'], '/', function () {
//     return 'POST AND GET is allowed';
// });
//available routes
// Route::get();
// Route::post();
// Route::put(); edit and update
// Route::patch(); 
// Route::delete(); delete data
// Route::options(); 

// Route::any('/Welcome', function () {
//     return 'Welcome to Hero Coder';
// });
// Route::redirect('/welcome','/');
// Route::permanentRedirect('/welcome','/');

// Route::get('/user', function (Request $request) {
//     dd($request->user());
//     return null;
// });

// Route::get('/user/{id}/{group}', function ($id,$group) {
//     return response($id. ' '.$group, 200);
// });

// Route::get('/request-json', function (){
//     return response()->json(['name'=>'Hero Coder', 'email'=>'herocoder@gmail.com']);
// });// pag request ng route at pagbalik ng data via json format

// Route::get('/download', function () {
    
//     $path = public_path().'/sample.txt';
//     $name = 'sample.txt';
//     $headers = array(
//         'Content-type: application/text-plain',
//     );
//     return response()->download($path, $name, $headers);
// });
// common routes naming
// index - show all data or Students
// show - show a single data or Students
// create - show form to add a new student
//store - store a data
//edit-show form to edit a data
//update - update a data
//destroy-show form to delete a data

Route::controller(UserController::class)->group(function (){
    Route::post('/login/process', 'process');
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::get('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/store', 'store');//store is the default route to store the data
    
});

Route::controller(StudentsController::class)->group(function (){
    Route::get('/','index')->middleware('auth');
    Route::get('/add/student','create');
    Route::post('/add/student','store');
    Route::get('/student/{id}','show');
    Route::put('/student/{student}','update');
    Route::delete('/student/{student}','destroy');
    Route::get('/students/search', 'search')->name('students.search');
});

