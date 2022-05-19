<?php

namespace Database\Factories;

use App\Models\TeacherModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TeacherFactory extends Factory
{

    protected $model = TeacherModel::class;
    
    public function definition()
    {
        return [
            "teacherName" => $this->faker->userName(),
            "teacherPassword" => "$2y$10$9mLqLJhvYyAGgaRMWyuJreIZCu0Er7osSxaT/JphjBHXfdhlWjBj2"
        ];
    }
}
