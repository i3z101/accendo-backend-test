<?php

namespace App\Http\Controllers;

use Ahc\Jwt\JWT;
use App\Helper\Helper;
use App\Http\Requests\StudentRequest;
use App\Models\CourseModel;
use App\Models\StudentCoursePivotModel;
use App\Models\StudentModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware("authorization")->except(["studentAuth"]);
    }

    /**
     * @param payload array|string|number
     * This method will help to create a token for logging in for authorization purposes by accepting the payload to be encoded into the token
     * @return string
     */

    private function createToken($payload) {
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        $token = $jwt->encode($payload);
        return $token;
    }



    /**
     * @param StudentRequest
     * This param is the request that accepts student informaion.
     * Also this request param holds the validation process, so no need to write a long validation code
     * In this method we will check:
     * if the student has an account, then we will generate only a token contains the student information
     * if there is no account for that student, it will be created automatically.
     * The purpose of combining the login and sign up process into one method for these reasons:
     * 1- We do not to hit the databse with same coming data which are student name and password.
     * 2- It will help the developers to write same logic of similar ideas with less and understandable code
     */
     
    function studentAuth(StudentRequest $request) {
        try {
            $request->validated();
            $existStudent = StudentModel::all()->where("studentName", "=", $request->safe()->studentName)->first();
            if($existStudent) {
                if(Hash::check($request->studentPassword, $existStudent->studentPassword)){
                    return Helper::returnResponse("Student $existStudent->studentName logged in successfully", [
                        "token" => $this->createToken([
                            "studentName" => $existStudent->studentName,
                            "studentId" => $existStudent->studentId
                        ])
                    ]);
                }else {
                    return Helper::returnResponse("student name or student password is not valid", [
                        "errors" => []
                    ], 422);
                }
            }else {
                $newStudent = StudentModel::create([
                    "studentName" => $request->safe()->studentName,
                    "studentPassword" => Hash::make($request->safe()->studentPassword)
                ]);
                return Helper::returnResponse("Student $newStudent->studentName signed up successfully",[ 
                    "token" => $this->createToken([
                        "studentName" => $newStudent->studentName,
                        "studentId" => $newStudent->studentId
                    ])
                ], 201);
            }
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }


    /**
     * This method will help the students to view all available courses and who teach it in the app,
     * Only courses with registered teachers will be shown. Courses without teachers will not be displayed
     * Students then can choose which course they want to enroll.
     * This method needs students to be logged in which means they should have registered/login
     */

    public function viewAvailableCourses() {
        try {

            
            $allCourses = StudentModel::allAvailableCourses();
            
            return Helper::returnResponse("", [
                "allCourses" => $allCourses,
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }


    /**
     * This method will help the students to register their courses in order to create homeworks for a specific course and only for students who enrolled in the course
     * request->courseId comes from the request body while request->studentId comes from authorization middleware after decoding the token
     */

    public function addCourse(Request $request) {
        try {
            $isCourseAlreadyAdded = StudentCoursePivotModel::where("studentId", "=", $request->studentId)->where("courseId", "=", $request->courseId)->first();
            if($isCourseAlreadyAdded) {
                return Helper::returnResponse("You already added this course to your list", [], 422);
            }
            StudentCoursePivotModel::create([
                "studentId" => $request->studentId,
                "courseId" => $request->courseId
            ]);
            return Helper::returnResponse("Course added to your list successfully", [], 201);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    /**
     * This method will fetch all courses belong to a student
     */
    public function registeredCourses(Request $request) {
        try {
            $courses = StudentModel::registeredCourses($request->studentId);
            return Helper::returnResponse("", [
                "course" => $courses
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }
}
