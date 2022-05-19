<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Requests\CourseRequest;
use App\Models\CourseModel;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CourseController extends Controller
{
    /**
     * Displaying all the courses created by the school.
     * This method should only accessed by the admin
     * @return json response contains the courses information
     */
    public function index()
    {
        try {
            $allCourses = CourseModel::with(["teachers", "homeworks"])->get();
            $allStudents = CourseModel::students();
            $students = [];
            /**
             * This for each will combine the students to be under each course instead of returning them in a seprate array
             */
            foreach ($allCourses as $course) {
                $course["students"] = [];
                foreach($allStudents as $student) {
                    if($course->courseId == $student->courseId) {
                       $students = array_merge($students, [
                            [
                                "studentId" => $student->studentId,
                                "studentName" => $student->studentName
                            ]
                        ]);
                    }
                }
                $course->students = $students;
                $students = [];
            }
            return Helper::returnResponse("", [
                "allCourses" => $allCourses,
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    /**
     * Store a new course to the dabase
     * @param  \Illuminate\Http\CourseRequest  $request
     * The request param will hold the course information with the validation as well
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $courseRequest)
    {
        try {
            $courseRequest->validated();
            CourseModel::create([
                "courseName" => $courseRequest->safe()->courseName,
                "courseSlug" => Str::slug($courseRequest->safe()->courseName)
            ]);
            return Helper::returnResponse("Course stored successfully", [], 201);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    /**
     * Display the specific course.
     *
     * @param  int  $courseId
     * @return \Illuminate\Http\Response
     */
    public function show($courseId)
    {
        try {
            $course = CourseModel::where("courseId", $courseId)->first();
            return Helper::returnResponse("", [
                "course" => $course
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    
}
