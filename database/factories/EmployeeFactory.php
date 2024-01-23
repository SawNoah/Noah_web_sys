<?php

namespace Database\Factories;

use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\EmployeeCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cookie>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Employee::class;

    public function definition(): array
    {
        $category = EmployeeCategory::count() >= 7 ? EmployeeCategory::inRandomOrder()->first()->id : EmployeeCategory::factory();

        return [
            'first_name' => $this->faker->text(5),
            'last_name' => $this->faker->text(8),
            'email' => $this->faker->email(),
            'position' => $this->faker->text(20),
            'salary' => '350000',
            'joined_date' => $this->faker->date(),
            'image' => '/storage/images/default_img.jpg',
            'category_id' => $category
        ];
    }
}
