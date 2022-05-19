<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\SolutionModel;
use App\Models\StudentModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware("authorization");
    }

    /**
     * This method will fetch all registered courses that belong to a student
     */
    public function index(Request $request) {
        try{
            
            $allCourses = StudentModel::registeredCourses($request->studentId);

            return Helper::returnResponse("", [
                "allCourses" => $allCourses
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    public function homeworks(Request $request) {
        try{
            $homeworks = StudentModel::homeworks($request->studentId);
            return Helper::returnResponse("", [
                "homeworks" => $homeworks
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }
}
