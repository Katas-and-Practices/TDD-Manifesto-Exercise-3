<?php

namespace Exercise3\Rules;

require_once 'RuleBase.php';
require_once 'RuleResult.php';

class CharacterLengthAtLeastNRule extends RuleBase
{
    private bool $success;

    public function __construct(
        private int $atLeastCount,
        private string $errorMessage = 'Password must be at least {0} characters long',
    ) {}

    public function apply(string $input): RuleResult
    {
        $this->success = strlen($input) >= $this->atLeastCount;
        $errorMessage = $this->getErrorMessage();

        return new RuleResult($this->success, $errorMessage);
    }

    private function getErrorMessage(): string
    {
        return $this->success
            ? ''
            : str_replace('{0}', $this->atLeastCount, $this->errorMessage);
    }
}