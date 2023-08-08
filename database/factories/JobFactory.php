<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $title = ['主任', '專員', '管理師', 
                '副主任',  '工程師', '顧問', '作業員', 
                '系統工程師', '助理工程師', '會計',
                '秘書', '客服員', '企劃', '銷售員'];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement($this->title),
            'description' =>fake()->paragraph(3, true),
            'salary' => fake()->numberBetween(5000,150_000),
            'location' => fake()->city,
            'category' => fake()->randomElement(Job::$category),
            'experience' => fake()->randomElement(Job::$experience),
        ];
    }
}
