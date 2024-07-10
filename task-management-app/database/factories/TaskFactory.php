<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employees = User::where('usertype', 'employee')->pluck('name')->toArray();
        return [
            'Task' => $this->faker->sentence(),
            'Description' => $this->faker->paragraph(),
            'Date_Given' => $this->faker->date(),
            'Due_Date' => $this->faker->date(),
            'Priority' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            'Status' => $this->faker->randomElement(['Assigned', 'In progress', 'Completed','Late','Cancelled']),
            'Assigned_By' => $this->faker->randomElement($employees),
            'Assigned_By_Usertype' => 'employee'
        ];
    }
}
