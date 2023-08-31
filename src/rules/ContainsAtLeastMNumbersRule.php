<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleBase.php';
require_once 'RuleResult.php';

class ContainsAtLeastMNumbersRule extends RuleBase
{
    public function __construct(
        public string $fieldName,
        private int $atLeastCount,
        private string $errorMessage = '{fieldname} must contain at least {0} numbers',
    ) {}

    protected function calculateSuccess()
    {
        return (bool)preg_match('/.*([0-9].*){' . $this->atLeastCount . ',}/', $this->input);
    }

    protected function getErrorMessage(): string
    {
        return $this->success
            ? ''
            : str_replace(['{fieldname}', '{0}'], [$this->fieldName, $this->atLeastCount], $this->errorMessage);
    }
}