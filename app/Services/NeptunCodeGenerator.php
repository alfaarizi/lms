<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User;

class NeptunCodeGenerator
{
    /**
     * Generate Neptun code in CCCCCC format,
     * where C is either a capital from the English alphabet or a number
     * @return string
     */
    public function generate(): string
    {
        do {
            $neptun = strtoupper(Str::random(6));
        } while (User::where('neptun', $neptun)->exists());
        return $neptun;
    }
}
