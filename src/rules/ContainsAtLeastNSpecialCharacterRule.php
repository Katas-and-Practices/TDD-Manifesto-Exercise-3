<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleBase.php';
require_once 'RuleResult.php';

class ContainsAtLeastNSpecialCharacterRule extends RuleBase
{
    public function __construct(
        public string $fieldName,
        private int $atLeastCount,
        private string $errorMessage = '{fieldname} must contain at least {0} special characters',
    ) {}

    protected function calculateSuccess()
    {
        return (bool)preg_match('/.*([,<.>\/?:;\'\"|\\\{\]}~!@#$%^&*()\-_+=].*){' . $this->atLeastCount . ',}/', $this->input);
    }

    protected function getErrorMessage(): string
    {
        return $this->success
            ? ''
            : str_replace(['{fieldname}', '{0}'], [$this->fieldName, $this->atLeastCount], $this->errorMessage);
    }
}