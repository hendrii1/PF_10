<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Auth;
use app\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
});
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::resource('employees', EmployeeController::class);

Auth::routes();

// Ensure this route is removed, as it's duplicated.
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

//Menambahkan Local Disk
Route::get('/local-disk', function() {
    Storage::disk('local')->put('local-example.txt', 'This is local example content');
    return asset('storage/local-example.txt');
});

//Meletakan file pada public disk
Route::get('/public-disk', function() {
    Storage::disk('public')->put('public-example.txt', 'This is public example content');
    return asset('storage/public-example.txt');
});

//Menampilkan isi file local
Route::get('/retrieve-local-file', function() {
    if (Storage::disk('local')->exists('local-example.txt')) {
        $contents = Storage::disk('local')->get('local-example.txt');
    } else {
        $contents = 'File does not exist';
    }

    return $contents;
});

//Menampilkan isi file public
Route::get('/retrieve-public-file', function() {
    if (Storage::disk('public')->exists('public-example.txt')) {
        $contents = Storage::disk('public')->get('public-example.txt');
    } else {
        $contents = 'File does not exist';
    }

    return $contents;
});

//Mendownload file local
Route::get('/download-local-file', function() {
    return Storage::download('local-example.txt', 'local file');
});

//Mendownload file public
Route::get('/download-public-file', function() {
    return Storage::download('public/public-example.txt', 'public file');
});

//Menampilkan URL
Route::get('/file-url', function() {
    // Just prepend "/storage" to the given path and return a relative URL
    $url = Storage::url('local-example.txt');
    return $url;
});

//Menampilkan Size
Route::get('/file-size', function() {
    $size = Storage::size('local-example.txt');
    return $size;
});

//Menampilkan path
Route::get('/file-path', function() {
    $path = Storage::path('local-example.txt');
    return $path;
});

//Menyimpan file via form
Route::get('/upload-example', function() {
    return view('upload_example');
});

Route::post('/upload-example', function(Request $request) {
    $path = $request->file('avatar')->store('public');
    return $path;
})->name('upload-example');

//Menghapus File pada storage
//Menghapus File Local
Route::get('/delete-local-file', function(Request $request) {
    Storage::disk('local')->delete('local-example.txt');
    return 'Deleted';
});

//Menghapus File Public
Route::get('/delete-public-file', function(Request $request) {
    Storage::disk('public')->delete('public-example.txt');
    return 'Deleted';
});

//Route Untuk Download dari Employee Controller
Route::get('download-file/{employeeId}', [EmployeeController::class, 'downloadFile'])->name('employees.downloadFile');


Route::get('getEmployees', [EmployeeController::class, 'getData'])->name('employees.getData');

Route::get('exportExcel', [EmployeeController::class, 'exportExcel'])->name('employees.exportExcel');

Route::get('exportPdf', [EmployeeController::class, 'exportPdf'])->name('employees.exportPdf');
