<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Cdinas;
use App\Http\Controllers\Csub;
use App\Http\Controllers\Crekening;
use App\Http\Controllers\Cjenis;
use App\Http\Controllers\Crincian;
use App\Http\Controllers\Csppd;
use App\Http\Controllers\PdfGenerator;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Storage;

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
    return redirect()->route('login');
    return view('welcome');

});
Route::get('/nosession', function () {
    return response()->json([
        'exc' => false,
        'data' => 'session has remove'
    ], 200);
});

// Route::view('/{path?}', 'react')
//     ->where('path', '.*');
// Route::prefix('home')->group(function(){

// });
Auth::routes();
Route::controller(HomeController::class)->name('home.')->prefix('home')->group(function(){
    Route::get('/','index')->name('index');
    Route::view('/{path?}', 'react')
        ->where('path', '.*');
});
Route::get('logout', function(){
    Auth::logout();
    Session::flush();
    return redirect('/login');
});
Route::controller(Cdinas::class)->name('api.')->prefix('api/dinas')->group(function(){
    Route::get('/','index')->name('index');
    Route::post('/added','added')->name('added');
    Route::post('/upded','upded')->name('upded');
    Route::post('/deled','deled')->name('deled');

    Route::get('/sess','sess')->name('sess');

    Route::get('/bidang/{kdDinas}','bidang')->name('bidang');
    $nm ='Bidang';
    Route::post('/added'.$nm,'added'.$nm)->name('added'.$nm);
    Route::post('/upded'.$nm,'upded'.$nm)->name('upded'.$nm);
    Route::post('/deled'.$nm,'deled'.$nm)->name('deled'.$nm);

    Route::get('/anggota/{kdDinas}/{kdDBidang}','anggota')->name('anggota');
    $nm ='Anggota';
    Route::post('/added'.$nm,'added'.$nm)->name('added'.$nm);
    Route::post('/upded'.$nm,'upded'.$nm)->name('upded'.$nm);
    Route::post('/deled'.$nm,'deled'.$nm)->name('deled'.$nm);

    Route::get('/rincian','rincian')->name('rincian');
    Route::get('/dinasBidangSub','dinasBidangSub')->name('dinasBidangSub');
    Route::get('/dinasDataBidang/{kdDinas}','dinasDataBidang')->name('dinasDataBidang');
    Route::get('/dinasDataBidangSub/{kdDinas}','dinasDataBidangSub')->name('dinasDataBidangSub');
    Route::get('/getSubBidang/{kdDinas}/{kdBidang}','getSubBidang')->name('getSubBidang');
    Route::get('/getUraianSub/{kdDinas}/{kdBidang}/{kdSub}','getUraianSub')->name('getUraianSub');




});
Route::controller(Csub::class)->name('api.')->prefix('api/sub')->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/sub/{kdDinas}','sub')->name('sub');
    Route::post('/setSubBidang','setSubBidang')->name('setSubBidang');
    Route::post('/delSubBidang','delSubBidang')->name('delSubBidang');

});
Route::controller(Crekening::class)->name('api.')->prefix('api/rekeningB')->group(function(){
    Route::get('/','index')->name('index');
});
Route::controller(Cjenis::class)->name('api.')->prefix('api/jenisP')->group(function(){
    Route::get('/','index')->name('index');
    Route::post('/added','added')->name('added');
    Route::post('/upded','upded')->name('upded');
    Route::post('/deled','deled')->name('deled');
    Route::get('/dataDukung/{kdJPJ}','dataDukung')->name('dataDukung');
    Route::post('/addedDukung','addedDukung')->name('addedDukung');
    Route::post('/updedDukung','updedDukung')->name('updedDukung');
    Route::post('/deledDukung','deledDukung')->name('deledDukung');
});
Route::controller(Crincian::class)->name('api.')->prefix('api/rincian')->group(function(){
    Route::get('/','index')->name('index');
    Route::post('/added','added')->name('added');
    Route::post('/upded','upded')->name('upded');
    Route::post('/deled','deled')->name('deled');

    Route::post('/addedTriwulan','addedTriwulan')->name('addedTriwulan');
    Route::post('/updedTriwulan','updedTriwulan')->name('updedTriwulan');
});

Route::controller(Csppd::class)->name('api.')->prefix('api/sppd')->group(function(){
    Route::get('/{param}','index')->name('index');
    Route::post('/added','added')->name('added');
    Route::post('/upded','upded')->name('upded');
    Route::post('/deled','deled')->name('deled');

    Route::post('/uploadDasar','uploadDasar')->name('uploadDasar');
    Route::post('/nextStep','nextStep')->name('nextStep');
    Route::post('/step3','step3')->name('step3');

    Route::post('/addedUser','addedUser')->name('addedUser');
    Route::post('/getAnggotaSelected','getAnggotaSelected')->name('getAnggotaSelected');
    Route::post('/delAnggotaSelected','delAnggotaSelected')->name('delAnggotaSelected');

    Route::post('/addWorkUraian','addWorkUraian')->name('addWorkUraian');
    Route::post('/updWorkUraian','updWorkUraian')->name('updWorkUraian');
    Route::post('/delWorkUraian','delWorkUraian')->name('delWorkUraian');
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->prefix('home')->groi;

Route::controller(PdfGenerator::class)->name('pdf.')->prefix('pdf')->group(function(){
    Route::get('/kwitansiSppd/{val}','kwitansiSppd')->name('kwitansiSppd');
    Route::get('/SuratTugasSppd/{val}','SuratTugasSppd')->name('SuratTugasSppd');
    Route::get('/sppdSetda/{val}','sppdSetda')->name('sppdSetda');
    Route::get('/sppdBupati/{val}','sppdBupati')->name('sppdBupati');


});


Route::get('storage/{filename}', function ($filename){
    $files ="app/public/pdf/sppd/".$filename;
    $path = storage_path($files);
    return response()->download($path, 'example.pdf', [], 'inline');
});
