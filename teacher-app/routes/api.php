<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Ahc\Jwt\JWT;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\TeacherController;

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


Route::prefix("v1/")->group(function(){
    Route::prefix("teachers/")->group(function () {
        Route::post("auth", [TeacherController::class, 'teacherAuth']);
        Route::post("add-course", [TeacherController::class, 'addCourse']);
        Route::get("view-registered-courses", [TeacherController::class, 'registeredCourses']);
        Route::get("view-available-courses", [TeacherController::class, "viewAvailableCourses"]);
        Route::post("add-solution-mark", [SolutionController::class, "addMarkToSolution"]);
        Route::get("view-solutions", [SolutionController::class, "viewHomeworkSolutions"]);
        Route::apiResource("homeworks", HomeworkController::class);
    });
    Route::apiResource("courses", CourseController::class);
});