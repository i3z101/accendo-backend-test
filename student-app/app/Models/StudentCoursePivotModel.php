<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCoursePivotModel extends Model
{
    use HasFactory;
    protected $table = "students_courses";
    protected $primaryKey = "id";
    protected $fillable = ["studentId", "courseId"];
    public $timestamps = false;
}
