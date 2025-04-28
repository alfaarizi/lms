<?php

namespace App\Services;

use App\Models\Subject;

class SubjectCodeGenerator
{

    /**
     * Generate Subject code in IK-SSSNNN format,
     * where S is a capital from the English alphabet, and N is number.
     * @return string
     */
    public function generate(): string
    {
        do {
            $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
            $numbers = substr(str_shuffle('0123456789'), 0, 3);
            $code = "IK-{$letters}{$numbers}";
        } while (Subject::where('code', $code)->exists());
        return $code;
    }
}
