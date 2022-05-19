<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Requests\SolutionMarkRequest;
use App\Models\HomeworkModel;
use Exception;
use Illuminate\Http\Request;

class SolutionController extends Controller
{

    public function __construct()
    {
        $this->middleware("authorization");
    }

    public function viewHomeworkSolutions(Request $request) {
        try{    
            $solutions = HomeworkModel::solutions($request->teacherId);
            return Helper::returnResponse("", [
                "solutions" => $solutions
            ]);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }

    /**
     * This method will update the mark field for the given solution id
     */
    public function addMarkToSolution(Request $request, SolutionMarkRequest $solutionMarkRequest) {
        try{   
            $solutionMarkRequest->validated();
            HomeworkModel::addMark($request->solutionId, $solutionMarkRequest->safe()->mark);
            return Helper::returnResponse("Mark has been added successfully", []);
        }catch(Exception $error) {
            return Helper::returnError($error);
        }
    }
}
