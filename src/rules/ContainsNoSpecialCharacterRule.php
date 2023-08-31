<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleBase.php';
require_once 'RuleResult.php';

class ContainsNoSpecialCharacterRule extends RuleBase
{
    private bool $success;

    public function __construct(
        public string $fieldName,
        private string $errorMessage = '{fieldname} must not contain any special characters',
    ) {}

    public function apply(string $input): RuleResult
    {
        $this->success = !(bool)preg_match('/.*([`,<.>\/?:;\'\"|\\\{\]}~!@#$%^&*()\-_+=].*){1,}/', $input);
        $errorMessage = $this->getErrorMessage();

        return new RuleResult($this->success, $errorMessage);
    }

    private function getErrorMessage(): string
    {
        return $this->success
            ? ''
            : str_replace('{fieldname}', $this->fieldName, $this->errorMessage);
    }
}