<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\CommentController;


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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//
//Route::get('/message', function(){
//    return response()->json([
//        'message' => 'Hello World!',
//        'status' => 200,
//    ]);
//});


// Student authentication routes done (Remains logout)
Route::post('student/login', [AuthenticationController::class, 'login']);
//Route::get('student/details', [AuthenticationController::class, 'studentDetails'])->middleware('auth:sanctum', 'abilities:student');
//Route::post('student/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum', 'abilities:student');



//Route::get('/courses', [CourseController::class, 'index']);
//Student secure routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('student/details', [AuthenticationController::class, 'studentDetails']);
    Route::post('student/logout', [AuthenticationController::class, 'logout']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/course/{id}', [CourseController::class, 'show']);

    Route::post('/course/{id}/video', [VideoController::class, 'store']);
    Route::delete('/course/{id}/video', [VideoController::class, 'destroy']);

    Route::post('/course/{id}/comment', [CommentController::class, 'courseCommentStore']);
    Route::delete('/course/{id}/comment', [CommentController::class, 'courseCommentDestroy']);

    Route::post('/video/{id}/comment', [CommentController::class, 'videoCommentStore']);
    Route::delete('/video/{id}/comment', [CommentController::class, 'videoCommentDestroy']);
//    Route::post('/course/{id}/video', [CourseController::class, 'store']);
});
