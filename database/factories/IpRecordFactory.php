<?php

namespace Database\Factories;

use App\Models\IpRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IpRecord>
 */
class IpRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ip_address' => $this->faker->unique()->ipv4(),
            'label' => $this->faker->word(),
            'comment' => $this->faker->sentence(),
        ];
    }
}
