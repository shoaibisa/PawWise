<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CEcontroller;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Authenticate;

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

Route::get('/',  [UserController::class, 'Home']);
// Route::get('/adduser', [UserController::class, 'AddUserView']);
Route::post('/adduser', [UserController::class, 'AddUser'])->name('adduser');
Route::post('/updateuser', [UserController::class, 'UpdateUser'])->name('updateuser');
 
Route::post('/userdelete', [UserController::class, 'DeleteUser'])->name('userdelete');

Route::get('/addresses/user/{id}', [UserController::class, 'GetAddresses']);

// get states by country

Route::get('/states/{cid}', [UserController::class, 'GetStates']);
Route::get('/city/{sid}', [UserController::class, 'GetCity']);
Route::get('/getcitybystate/{id}', [AddressController::class, 'getSateByCity']);

// //transaction
// Route::get('/addtransaction/user/{uid}',  [UserController::class, 'GetAddTransaction']);
// Route::post('/addtrasaction', [UserController::class, 'AddTransaction'])->name('addtrasaction');
// Route::get("/gettransaction/{userId}", [UserController::class, 'GetNetBalance']);

//auth
Route::middleware('guest')->group(
    function () {
        Route::get('/register', [AuthController::class, 'getUserReg'])->name('register');
        Route::post('/register', [AuthController::class, 'postRegister']);
        Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'postLogin']);
    }
);
//user
Route::middleware('auth')->group(
    function () {
        Route::get('/profile', [UserController::class, 'SingleUser']);
        Route::get('/dashboard', [UserController::class, 'GetDashboard'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    }
);
// only visible by admins users

Route::group(['middleware' => ['role:admin']], function () {
   Route::get('/users',[AdminController::class,"GetAllUsers"]);
   Route::get('/assignerole/{uid}/{rid}/{ischecked}',[AdminController::class,'AssignRoles']);
   Route::get('/userverification/{id}',[AdminController::class,'accountVerifyAction']);

});

//banks

Route::group(['middleware'=>['role:bank']], function(){
    // Route::get('/users',[BankController::class,'GetAllUsers']);
    Route::get('/banktransactions',[BankController::class,'AllBankTransactions']);
    Route::get('/verifying/{tid}',[BankController::class,'VerifyTransaction']);
    Route::get('/bankusers',[BankController::class,'BankAllUsers']);
    Route::get('/VerifyUser/{bid}',[BankController::class,'VerifyUser']);
    
});


//users 
Route::group(['middleware'=>['role:user']], function(){
        //trasnactions
        Route::get('/addtransaction',[TransactionController::class,'GetAddTransaction'])->name('addtrasaction');
        Route::post('/addtransaction',[TransactionController::class,'AddTransaction']);
        Route::get('/transactions/user/{uid}',[TransactionController::class,'GetUserTransactions']);
        Route::get('/askbankrequest',[UserController::class,'AskBankRequest'])->name('askbankrequest');
        Route::post('/addrequestbank',[UserController::class,'AddRequestBank'])->name('addrequestbank');
});

//public routes

Route::get('/banks', [BankController::class,'AllBanks']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get("/editor",[CEcontroller::class,'geteditor']);
Route::post('/save-content',[CEcontroller::class,'SaveContent'])->name('save-content');
Route::get('/code/{id}',[CEcontroller::class,'ShowCode']);

// require __DIR__ . '/auth.php';
