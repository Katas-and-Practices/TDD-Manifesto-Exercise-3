<?php

namespace Exercise3\Rules;

require_once 'RuleBase.php';
require_once 'RuleResult.php';

class ContainsAtLeastMNumbersRule extends RuleBase
{
    private bool $success;

    public function __construct(
        public string $fieldName,
        private int $atLeastCount,
        private string $errorMessage = '{fieldname} must contain at least {0} numbers',
    ) {}

    public function apply(string $input): RuleResult
    {
        $this->success = preg_match('/.*([0-9].*){' . $this->atLeastCount . ',}/', $input);
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