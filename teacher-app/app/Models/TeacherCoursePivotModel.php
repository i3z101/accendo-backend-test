<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCoursePivotModel extends Model
{
    use HasFactory;
    protected $table = "teachers_courses";
    protected $primaryKey = "id";
    protected $fillable = ["teacherId", "courseId"];
    public $timestamps = false;
}
