<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleBase.php';

abstract class RuleBase
{
    protected string $input;
    protected bool $success;

    public function apply(string $input): RuleResult
    {
        $this->input = $input;
        $this->success = $this->calculateSuccess();

        return $this->generateRuleResult();
    }

    protected function generateRuleResult(): RuleResult
    {
        $errorMessage = $this->getErrorMessage();

        return new RuleResult($this->success, $errorMessage);
    }

    protected abstract function calculateSuccess();
    protected abstract function getErrorMessage(): string;
}