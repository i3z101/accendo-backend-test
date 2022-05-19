<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix("v1/students/")->group(function(){
    Route::post("auth", [StudentController::class, 'studentAuth']);
    Route::post("add-course", [StudentController::class, 'addCourse']);
    Route::get("view-registered-courses", [StudentController::class, 'registeredCourses']);
    Route::post("add-solution", [SolutionController::class, 'addSolution']);
    Route::get("view-solutions", [SolutionController::class, 'solutions']);
    Route::get("view-available-courses", [StudentController::class, 'viewAvailableCourses']);
    Route::get("view-homeworks", [CourseController::class, 'homeworks']);
});