<?php

namespace App\Actions\Driver;

use App\Models\Driver;

class Create
{
    public function execute(array $data): Driver
    {
        return Driver::create($data);
    }
}