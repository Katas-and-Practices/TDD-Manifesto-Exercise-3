<?php

namespace Exercise3;

use Exercise3\Rules\RuleBase;
use Exercise3\Rules\RuleResult;

class Validator
{
    public function __construct() {}

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

        return $this->aggregateRuleApplicationResults($rawResults);
    }

    private function aggregateRuleApplicationResults(array $rawResults): array
    {
        $totalSuccess = true;
        $errorMessageList = [];

        foreach ($rawResults as $fieldName => $results) {
            $success = true;

            /** @var RuleResult $result */
            foreach ($results as $result) {
                $isCurrentSuccessful = $result->getSuccess();
                $success = $success && $isCurrentSuccessful;
                $totalSuccess = $totalSuccess && $success;

                if (!$isCurrentSuccessful) {
                    $errorMessageList[$fieldName][] = $result->getErrorMessage();
                }
            }

            if (array_key_exists($fieldName, $errorMessageList)) {
                $errorMessageList[$fieldName] = implode("\n", $errorMessageList[$fieldName]);
            }

        }

        return array_merge(['success' => $totalSuccess], count($errorMessageList) ? ['errors' => $errorMessageList] : []);
    }
}