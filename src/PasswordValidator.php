<?php

namespace Exercise3;

class PasswordValidator
{
    public function validate(string $inputPassword)
    {
        if (strlen($inputPassword) > 7) {
            return true;
        }

        throw new \Exception('Password must be at least 8 characters long');
    }
}