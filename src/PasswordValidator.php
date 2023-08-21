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
        if (!preg_match('/.*[0-9]{2}.*/', $inputPassword)) {
            $success = false;
            $errorMessage = $errorMessage ?? 'Password must contain at least 2 numbers';
        }

        return array_merge(['success' => $success], $errorMessage ? ['error-message' => $errorMessage] : []);
    }
}