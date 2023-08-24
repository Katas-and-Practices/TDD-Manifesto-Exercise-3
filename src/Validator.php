<?php

declare(strict_types=1);

namespace Exercise3;

require_once 'rules/RuleApplicationAggregator.php';

use Exercise3\Rules\RuleApplicationAggregator;
use Exercise3\Rules\RuleBase;

class Validator
{
    public function __construct(
        private RuleApplicationAggregator $ruleApplicationAggregator,
    ) {}

    public function validate(array $input)
    {
        return $this->applyRulesToFields($input);
    }

    private function applyRulesToFields(array $inputData): array
    {
        foreach ($inputData as $fieldName => $fieldData) {
            $value = $fieldData['value'];
            $rules = $fieldData['rules'];

            /** @var RuleBase $rule */
            foreach ($rules as $rule) {
                $rawResults[$fieldName][] = $rule->apply($value);
            }
        }

        return $this->ruleApplicationAggregator->aggregate($rawResults);
    }
}