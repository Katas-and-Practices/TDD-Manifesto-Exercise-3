<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleBase.php';
require_once 'RuleResult.php';

class ContainsAtLeastNSpecialCharacterRule extends RuleBase
{
    private bool $success;

    public function __construct(
        public string $fieldName,
        private int $atLeastCount,
        private string $errorMessage = '{fieldname} must contain at least {0} special characters',
    ) {}

    public function apply(string $input): RuleResult
    {
        $this->success = (bool)preg_match('/.*([,<.>\/?:;\'\"|\\\{\]}~!@#$%^&*()\-_+=].*){' . $this->atLeastCount . ',}/', $input);
        $errorMessage = $this->getErrorMessage();

        return new RuleResult($this->success, $errorMessage);
    }

    private function getErrorMessage(): string
    {
        return $this->success
            ? ''
            : str_replace(['{fieldname}', '{0}'], [$this->fieldName, $this->atLeastCount], $this->errorMessage);
    }
}