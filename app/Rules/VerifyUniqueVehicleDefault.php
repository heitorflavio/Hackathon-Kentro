<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use App\Models\Vehicle;

class VerifyUniqueVehicleDefault implements ValidationRule
{
    private array $vehicle;

    public function __construct(array $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       // verificar se existe algum outro veículo com a flag default = 1 para o usuário atual
        $vehicle = Vehicle::where('driver_id', auth()->user()->driver->id)
            ->where('default', 1)
            ->where('license_plate', '!=', $this->vehicle['license_plate'])
            ->first();

        if ($vehicle && $this->vehicle['default'] == 1) {
            $fail('There is already a default vehicle for this driver');
        }
    }
}
