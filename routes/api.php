<?php

use App\Http\Controllers\BloggerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailVerficationController;
use App\Http\Controllers\PController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Mail\HelloMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
 
//user
Route::post('register_user',[UserController::class,'Register']);
// Route::post('login_user', function (Request $request) {
//     // استدعاء التابع login من UserController
//     $userController = app()->make(UserController::class);
//     $response = $userController->callAction('login', [$request]);

//     // بعد تسجيل الدخول بنجاح، قم بإرسال البريد الإلكتروني
//     if ($response->getStatusCode() === 200) {
//         $user = auth()->user();

//         if ($user) {
//             Mail::to('zeinalabdensafi@gmail.com')->send(new HelloMail($user));
//         }
//     }

//     return response($response->getContent(), $response->getStatusCode(), $response->headers->all());
// });

 Route::post('login_user',[UserController::class,'login']);
Route::post('email_verified',[EmailVerficationController::class,'email_verified']);

//blogger
Route::post('register_blogger',[BloggerController::class,'register']);
Route::post('login_blogger',[BloggerController::class,'login']);


Route::group(['middleware'=> ['auth:sanctum']],function(){
    
    //user
    Route::get('logout_user',[UserController::class,'logout']);
    Route::get('profile_user',[UserController::class,'profile']);
    
    Route::get('email_verified',[EmailVerficationController::class,'sendEmailVerification']);

    //blogger
    Route::get('logout_blogger',[BloggerController::class,'logout']);
    Route::get('profile_blogger',[BloggerController::class,'profile']);


    //post
    Route::post('create_post',[PostController::class,'create_post']);
    Route::get('my_post',[PostController::class,'my_posts']);
    Route::get('all_posts',[PostController::class,'all_posts']);

    //comments
    Route::post('create_comments',[CommentController::class,'create_comment']);

    //category
    Route::get('all_category',[CategoryController::class,'show']);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//to prefix many routes 
/*Route::prefix('admin')->group(function(){
//...
});*/
/*
Route::group(['middleware'=>['middleware name']],function (){

});
*/