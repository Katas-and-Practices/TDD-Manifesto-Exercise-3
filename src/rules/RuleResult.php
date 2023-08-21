<?php

namespace Exercise3\Rules;

class RuleResult
{
    public function __construct(
        private bool $success = false,
        private string $errorMessage = '',
    ) {}

    public function getSuccess()
    {
        return $this->success;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}