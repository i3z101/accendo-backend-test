<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Requests\HomeworkRequest;
use App\Models\HomeworkModel;
use Exception;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{

    public function __construct()
    {
        $this->middleware('authorization');
    }

    /**
     * @param homeworkId int
     * This method will help to find and return exist homework
     * It is private because we only want it in the class
     */

    private function findExistHomework(int $homeworkId) {
        return HomeworkModel::where("homeworkId", "=", $homeworkId)->first();
    }

    /**
     * Display a all the homeworks created by the owner teacher.
     */
    public function index(Request $request)
    {
        try {
            $homeworks = HomeworkModel::with('courses:courses.courseId,courses.courseName')->where("teacherId", "=", $request->teacherId)->get();
            return Helper::returnResponse("", [
                "homeworks" => $homeworks
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    /**
     * @param Request
     * This param will contain the teacher data that encoded from the sent token
     * @param HomeworkRequest
     * This param holds homework details and which course belongs to the homework as well as the validation process.
     * This method will help to create a new homework by only the authorized teachers.
     */
    public function store(Request $request, HomeworkRequest $homeworkRequest)
    {
        try {
            $homeworkRequest->validated();
            HomeworkModel::create([
                "homeworkQuestion" => $homeworkRequest->safe()->homeworkQuestion,
                "courseId" => $request->courseId,
                "teacherId" => $request->teacherId
            ]);
            return Helper::returnResponse("Homework has been created successfully", [], 201);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }


/**
     * @param HomeworkRequest
     * This param holds homework details and which course belongs to the homework as well as the validation process.
     * @param homeworkId int
     * This method will help to update an existing homework by only the authorized teacher.
     */
    public function update(HomeworkRequest $homeworkRequest, int $homeworkId)
    {
        try {
            $homeworkRequest->validated();
            $existHomework = $this->findExistHomework($homeworkId);
            if(!$existHomework) {
                return Helper::returnResponse("Home work is not found", [], 404);
            }
            $existHomework->update([
                "homeworkQuestion" => $homeworkRequest->safe()->homeworkQuestion
            ]);
            return Helper::returnResponse("Homework has been updated successfully", [], 200);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    /**
     * @param homeworkId int
     * Remove the specified homework from the database only by the authorized teacher who created the home work.
     */
    public function destroy(int $homeworkId)
    {
        try {
            $existHomework = $this->findExistHomework($homeworkId);
            if(!$existHomework) {
                return Helper::returnResponse("Home work is not found", [], 404);
            }
            $existHomework->delete();
            return Helper::returnResponse("Homework has been deleted successfully", [], 200);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }
}
