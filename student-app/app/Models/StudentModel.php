<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentModel extends Model
{
    use HasFactory;
    protected $table = "students";
    protected $primaryKey = "studentId";
    protected $fillable = ["studentName", "studentPassword"];
    protected $hidden = ["studentPassword"];
    public $timestamps = false;
    
    protected static function newFactory() {
        return StudentFactory::new();
    }

        /**
     * @param rawCoursesWithTeachers array
     * In this method we filter all the courses records and combine all teachers who teach the same course under one array.
     * As we know SQL will not return the same joined records under one array.
     * What SQL will return:
     * [
     *   {
     *      courseId: 1,
     *      courseName: "database"
     *      teacherName: "John"
     *   },
     *   {
     *      courseId: 1,
     *      courseName: "database"
     *      teacherName: "Ali"
     *   },
     *   ...other courses
     * ]
     * We can see duplication of the course name
     * ================
     * What filterCoursesWithTeachers will return:
     * [
     *   {
     *      courseId: 1,
     *      courseName: "database"
     *      teachers: ["John", "Ali"]
     *   },
     *   ...other courses
     * ]
     */
    private static function filterCoursesWithTeachers(array $rawCoursesWithTeachers) {
        define("ALL_COURSES_LENGTH", count($rawCoursesWithTeachers));
        $courses = array();
        for($i=0; $i < ALL_COURSES_LENGTH; $i++){
            $index = array_search($rawCoursesWithTeachers[$i]->courseId, array_column($courses, "courseId"));
            $courses[$i] = [
                "courseId" => $rawCoursesWithTeachers[$i]->courseId,
                "courseName" => $rawCoursesWithTeachers[$i]->courseName,
                "teachers" => array(
                    [
                    "teacherId" => $rawCoursesWithTeachers[$i]->teacherId,
                    "teacherName" => $rawCoursesWithTeachers[$i]->teacherName
                    ]
                )
            ];
            if($i == (ALL_COURSES_LENGTH -1)) {
                $courses = array_filter($courses, function($value) {
                    return $value["courseId"] != -1;
                });
            }else if($index !== false){
                array_push($courses[$index]["teachers"], [
                        "teacherId" => $rawCoursesWithTeachers[$i]->teacherId,
                        "teacherName" => $rawCoursesWithTeachers[$i]->teacherName
                ]);
                /**
                 * Replace the current index with courseId = -1 because we don't need to remove the whole element from the courses array to avoid index errors.
                 * When we reach to last element in the courses array we will remove all elements with courseId = -1
                 */
                $courses[$i] = [
                    "courseId" => -1
                ];
            }
        }
        //To remove the index to be the key of each element
        return array_values($courses);
    }


    /**
     * @param studentId int
     * To fetch all homeworks related to the student by student id
     **/
    public static function homeworks(int $studentId) {
        return DB::table("homeworks")->select(["homeworks.homeworkId", "homeworks.homeworkQuestion", "courses.courseName"])
        ->join("courses", "homeworks.courseId", "=", "courses.courseId")
        ->join("students_courses", "courses.courseId", "=", "students_courses.courseId")
        ->where("students_courses.studentId", "=", $studentId)
        ->get()->toArray();
    }


    /**
     * To fetch all courses with related teachers
     */
    public static function allAvailableCourses() {
        //We used orderBy to fetch the same courseId below each other
        $allJoinedCoursesWithTeachers = DB::table("courses")->select(["courses.courseId", "courses.courseName", "teachers.teacherId", "teachers.teacherName"])
        ->join("teachers_courses", "courses.courseId", "=", "teachers_courses.courseId")
        ->join("teachers", "teachers_courses.teacherId", "=", "teachers.teacherId")->orderBy("courses.courseId")->get()->toArray();

        $allCourses = StudentModel::filterCoursesWithTeachers($allJoinedCoursesWithTeachers);
        
        return $allCourses;
    }


    /**
     * @param studentId int
     * To fetch all registered courses belong to a student by the student id
     */
    public static function registeredCourses(int $studentId) {
        return DB::table("courses")->select(["courses.courseId", "courses.courseName"])
            ->join("students_courses", "courses.courseId", "=", "students_courses.courseId")
            ->where("students_courses.studentId", "=", $studentId)->get()->toArray();
    } 
}
