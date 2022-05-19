<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SolutionModel extends Model
{
    use HasFactory;
    protected $table = "solutions";
    protected $primaryKey = "solutionId";
    protected $fillable = ["solution", "studentId", "homeworkId"];

    
    
    /**
     * @param studentId int
     * To fetch all solutions with the related homework
     */
    public static function solutions(int $studentId) {
        return DB::table("solutions")->select(["solutions.solutionId", "solutions.solution", "solutions.mark", "homeworks.homeworkQuestion"])
            ->join("homeworks", "solutions.homeworkId", "=", "homeworks.homeworkId")->where("studentId", "=", $studentId)->get()->toArray();
    }
    
    
}
