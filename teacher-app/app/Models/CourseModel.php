<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Shared\Student;

class CourseModel extends Model
{
    use HasFactory;
    protected $table = "courses";
    protected $primaryKey = "courseId";
    protected $fillable = ["courseName", "courseSlug"];
    protected $hidden = ["pivot"];
    public $timestamps = false;

    public function teachers(){
        return $this->belongsToMany(
            TeacherModel::class,
            "teachers_courses",
            "courseId",
            "teacherId"
        );
    }

    public function homeworks() {
        return $this->hasMany(
            HomeworkModel::class,
            "courseId",
            "courseId"
        );
    }

    /**
     * To fetch all students who registered courses
     */
    public static function students() {
        return DB::table("courses")->select(["courses.courseId", "students.studentId" ,"students.studentName"])
        ->join("students_courses", "courses.courseId", "=", "students_courses.courseId")
        ->join("students", "students_courses.studentId", "=", "students.studentId")
        ->get()->toArray();
    }

    /**
     * @param teacherId int
     * This method will fetch all courses that belong to a teacher by teacherId 
     */
    public static function registeredCourses(int $teacherId) {
        return DB::table("courses")->select(["courses.courseId", "courses.courseName"])
        ->join("teachers_courses", "courses.courseId", "=", "teachers_courses.courseId")
        ->where("teachers_courses.teacherId", "=", $teacherId)->get()->toArray();
    }

}
