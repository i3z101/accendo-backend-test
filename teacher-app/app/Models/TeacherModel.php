<?php

namespace App\Models;

use Database\Factories\TeacherFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherModel extends Model
{
    use HasFactory;
    protected $table = "teachers";
    protected $primaryKey = "teacherId";
    protected $fillable = ["teacherName", "teacherPassword"];
    protected $hidden = ["teacherPassword", "pivot"];
    
    public $timestamps = false;

    protected static function newFactory()
    {
        return TeacherFactory::new();
    }

    public function courses(){
        return $this->hasManyThrough(
            CourseModel::class,
            TeacherCoursePivotModel::class,
            "teacherId",
            "courseId",
            "teacherId",
            "courseId"
        );
    }
}
