<?php

namespace Exercise3;

use Exercise3\Rules\RuleBase;
use Exercise3\Rules\RuleResult;

class ValidatorRunner
{
    public function __construct(
        public Validator $validator,
    ) {}

    public function validate(string $input)
    {
        return $this->applyRules($input);
    }

    private function applyRules(string $input): array
    {
        $rawResults = [];
        $ruleset = $this->validator->getRules();

        /** @var RuleBase $ruleObject */
        foreach ($ruleset as $rule) {
            $rawResults[] = $rule->apply($input);
        }

        return $this->aggregateRuleApplicationResults($rawResults);
    }

    private function aggregateRuleApplicationResults(array $rawResults): array
    {
        $success = true;
        $errorMessage = '';

        /** @var RuleResult $result */
        foreach ($rawResults as $result) {
            $success = $success && $result->getSuccess();
            $newErrorMessage = $result->getErrorMessage();
            $errorMessage .= ($newErrorMessage && $errorMessage ? "\n" : '') . $result->getErrorMessage();
        }

        return array_merge(['success' => $success], $errorMessage ? ['error-message' => $errorMessage] : []);
    }
}