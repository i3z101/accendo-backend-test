<?php

namespace Database\Factories;

use App\Models\StudentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{

    protected $model = StudentModel::class;
    
    public function definition()
    {
        return [
            "studentName" => $this->faker->userName(),
            "studentPassword" => "$2y$10\$ncFQIhNegxQlTGTwEdTITe84ITp0.VvpF10TWt.6Y.1NfULBCouYu" //AZZOZz12345#
        ];
    }
}
