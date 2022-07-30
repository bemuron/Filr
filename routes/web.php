<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//upload a file
Route::post('/upload-file', [FilesController::class, 'store']);

//edit notes for a file
Route::post('/edit-file-note', [FilesController::class, 'saveNoteEdit']);

//get all files a user has
Route::get('/all-files', [FilesController::class, 'show']);

//get a single file for upload
Route::get('/get-single-file/{file_id}', [FilesController::class, 'getSingleFile']);

//get total upload file size
Route::get('/get-all-files-size', [FilesController::class, 'totalUploadsSize']);

//donwload a file
Route::get('/download-file/{file_id}', [FilesController::class, 'downloadFile']);

//delete a file
Route::post('/delete-file', [FilesController::class, 'destroy']);
