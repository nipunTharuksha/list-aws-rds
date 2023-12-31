<?php

use Illuminate\Support\Facades\App;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
/*   $t = App::make('aws')->createClient('rds',['region' => 'ap-south-1']);
  $log =  $t->describeEvents(['Duration' => 10000,'SourceIdentifier'=> 'database-1','SourceType' => 'db-instance']);
  dd($log);*/
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::view('/{any}', 'dashboard')->where('any', '.*');


