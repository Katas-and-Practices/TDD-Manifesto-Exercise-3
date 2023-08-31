<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleBase.php';
require_once 'RuleResult.php';

class ContainsNoSpecialCharacterRule extends RuleBase
{
    public function __construct(
        public string $fieldName,
        private string $errorMessage = '{fieldname} must not contain any special characters',
    ) {}

    protected function calculateSuccess()
    {
        return !(bool)preg_match('/.*([`,<.>\/?:;\'\"|\\\{\]}~!@#$%^&*()\-_+=].*){1,}/', $this->input);
    }

    protected function getErrorMessage(): string
    {
        return $this->success
            ? ''
            : str_replace('{fieldname}', $this->fieldName, $this->errorMessage);
    }
}