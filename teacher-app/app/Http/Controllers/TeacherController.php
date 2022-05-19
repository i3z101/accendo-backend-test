<?php

namespace App\Http\Controllers;

use Ahc\Jwt\JWT;
use App\Http\Requests\TeacherRequest;
use App\Models\TeacherModel;
use Exception;
use App\Helper\Helper;
use App\Http\Requests\HomeworkRequest;
use App\Models\CourseModel;
use App\Models\HomeworkModel;
use App\Models\TeacherCoursePivotModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{

    public function __construct()
    {
        $this->middleware("authorization")->except(["teacherAuth"]);
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
     * @param TeacherRequest
     * This param is the request that accepts teacher informaion.
     * Also this request param holds the validation process, so no need to write a long validation code
     * In this method we will check:
     * if the teacher has an account, then we will generate only a token contains the teacher information
     * if there is no account for that teacher, it will be created automatically.
     * The purpose of combining the login and sign up process into one method for these reasons:
     * 1- We do not to hit the databse with same coming data which are teacher name and password.
     * 2- It will help the developers to write same logic of similar ideas with less and understandable code
     */
     
    public function teacherAuth(TeacherRequest $teacherRequest) {
        try {
            $teacherRequest->validated();
            $existTeacher = TeacherModel::all()->where("teacherName", "=", $teacherRequest->safe()->teacherName)->first();
            if($existTeacher) {
                if(Hash::check($teacherRequest->safe()->teacherPassword, $existTeacher->teacherPassword)){
                    return Helper::returnResponse("Teacher $existTeacher->teacherName logged in successfully", [
                        "token" => $this->createToken([
                            "teacherName" => $existTeacher->teacherName,
                            "teacherId" => $existTeacher->teacherId
                        ])
                    ]);
                }else {
                    return Helper::returnResponse("Teacher name or Teacher password is not valid", [
                        "errors" => []
                    ], 422);
                }
            }else {
                $newTeacher = TeacherModel::create([
                    "teacherName" => $teacherRequest->safe()->teacherName,
                    "teacherPassword" => Hash::make($teacherRequest->safe()->teacherPassword)
                ]);
                return Helper::returnResponse("Teacher $newTeacher->teacherName signed up successfully",[ 
                    "token" => $this->createToken([
                        "teacherName" => $newTeacher->teacherName,
                        "teacherId" => $newTeacher->teacherId
                    ])
                ], 201);
            }
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }


    /**
     * This method will help the teachers to view all available courses in the app,
     * Teachers then can choose which course they want to teach.
     * This method needs teachers to be logged in which means they should have registered/login
     */

    public function viewAvailableCourses() {
        try {
            $allCourses = CourseModel::all(["courseId", "courseName"]);
            return Helper::returnResponse("", [
                "allCourses" => $allCourses,
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }



    /**
     * This method will help the teachers to register their courses in order to create homeworks for a specific course and only for students who enrolled in the course
     * request->courseId comes from the request body while request->teacherId comes from authorization middleware after decoding the token
     * Teachers can only register the course once to avoid duplication records
     */

    public function addCourse(Request $request) {
        try {
            $isCourseAlreadyAdded = TeacherCoursePivotModel::where("teacherId", "=", $request->teacherId)->where("courseId", "=", $request->courseId)->first();
            if($isCourseAlreadyAdded) {
                return Helper::returnResponse("You already added this course to your list", [], 422);
            }
            TeacherCoursePivotModel::create([
                "teacherId" => $request->teacherId,
                "courseId" => $request->courseId
            ]);
            return Helper::returnResponse("Course added to your list successfully", [], 201);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    /**
     * This method will fetch all courses belong to a teacher
     */
    public function registeredCourses(Request $request) {
        try {
            $courses = CourseModel::registeredCourses($request->teacherId);
            return Helper::returnResponse("", [
                "course" => $courses
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

}
