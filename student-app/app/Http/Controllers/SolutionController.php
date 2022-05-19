<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Requests\SolutionRequest;
use App\Models\SolutionModel;
use Exception;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('authorization');
    }

    /**
     * @param Request will handle the api token and enocded data
     * @param SolutionRequest will handle the solution information and its validation
     * This method will store the student new solution after validating the data
     * A student can submit only one solution to a given homework to avoid duplication records
     */
    public function addSolution(Request $request, SolutionRequest $solutionRequest) {
        try{
            $solutionRequest->validated();
            $isSolutionExist = SolutionModel::where("studentId", "=", $request->studentId)->where("homeworkId", "=", $request->homeworkId)->get()->first();
            if($isSolutionExist) {
                return Helper::returnResponse("Your solution is already added", [], 422);
            }
            SolutionModel::create([
                "solution" => $solutionRequest->safe()->solution,
                "studentId" => $request->studentId,
                "homeworkId" => $request->homeworkId
            ]);
            return Helper::returnResponse("Solution has been added successfully", [], 201);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

     /**
     * @param Request will handle the api token and enocded data
     * This method will fetch the students solutions
     */
    public function solutions(Request $request) {
        try{
            $solutions = SolutionModel::solutions($request->studentId);
            return Helper::returnResponse("", [
                "solutions" => $solutions
            ], 200);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }
}
