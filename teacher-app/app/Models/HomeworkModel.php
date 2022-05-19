<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HomeworkModel extends Model
{
    use HasFactory;
    protected $table = "homeworks";
    protected $primaryKey = "homeworkId";
    protected $fillable = ["homeworkQuestion", "courseId", "teacherId"];
    protected $hidden = ["teacherId", "courseId"];
    public $timestamps = false;

    public function courses() {
        return $this->belongsTo(
            CourseModel::class,
            "courseId",
            "courseId"
        );
    }

    /**
     * @param teacherId int
     * To fetch solutions of homeworks that belong to courses that taught by the teacher by teacher id
     */
    public static function solutions(int $teacherId) {
        return DB::table("solutions")->select(["solutions.solutionId", "solutions.solution", "solutions.mark", "homeworks.homeworkQuestion", "students.studentName"])
            ->join("homeworks", "solutions.homeworkId", "=", "homeworks.homeworkId")
            ->join("students", "solutions.studentId", "=", "students.studentId")
            ->where("homeworks.teacherId", "=", $teacherId)
            ->get()->toArray();
    }

    public static function addMark(int $solutionId, int $mark) {
        DB::table("solutions")->where("solutions.solutionId", "=", $solutionId)->update([
            "mark" => $mark
        ]);
    }
}
