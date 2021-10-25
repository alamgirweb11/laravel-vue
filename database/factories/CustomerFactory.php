<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
              'name' => $this->faker->name(),
              'mobile' => $this->faker->phoneNumber(),
              'email' => $this->faker->unique()->freeEmail(),
              'address' => $this->faker->address(),
              'image' => $this->faker->image('public/uploads/customers',640,480, null, false),
              'total' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 500.00, $max = 50000.00),
              'status' => rand(0,1)
        ];
    }
}
