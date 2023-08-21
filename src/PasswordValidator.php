<?php

namespace Exercise3;

class PasswordValidator
{
    public function validate(string $inputPassword)
    {
        $errorMessage = null;
        $success = false;

        if (strlen($inputPassword) > 7) {
            $success = true;
        }
        else {
            $errorMessage = 'Password must be at least 8 characters long';
        }

        return array_merge(['success' => $success], $errorMessage ? ['error-message' => $errorMessage] : []);
    }
}