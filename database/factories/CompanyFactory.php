<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'iban' => $this->faker->iban('FR'),
            'bic' => strtoupper($this->faker->lexify('????????')),
            'payment_instructions' => $this->faker->sentence(),
        ];
    }
}
