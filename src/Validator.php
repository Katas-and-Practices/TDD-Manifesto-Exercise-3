<?php

declare(strict_types=1);

namespace Exercise3;

require_once 'rules/RuleResult.php';

use Exercise3\Rules\RuleBase;
use Exercise3\Rules\RuleResult;

class Validator
{
    private $errorMessageList = [];
    private bool $success = true;

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
                $ruleResults[$fieldName][] = $rule->apply($value);
            }
        }

        return $this->aggregateRuleResults($ruleResults);
    }

    private function aggregateRuleResults(array $rawResults): array
    {
        foreach ($rawResults as $fieldName => $fieldValidationResults) {
            $this->addFieldErrors($fieldValidationResults, $fieldName);
        }

        return $this->generateFinalAggregationResult();
    }

    private function addFieldErrors(array $validationResults, string $fieldName): void
    {
        /** @var RuleResult $result */
        foreach ($validationResults as $result) {
            $isCurrentSuccessful = $result->getSuccess();
            $this->success = $this->success && $isCurrentSuccessful;

            if (!$isCurrentSuccessful) {
                $this->addFieldErrorMessage($result, $fieldName);
            }
        }

        if (array_key_exists($fieldName, $this->errorMessageList)) {
            $this->formatFieldErrorMessages($fieldName);
        }
    }

    private function addFieldErrorMessage(RuleResult $result, string $fieldName): void
    {
        $this->errorMessageList[$fieldName][] = $result->getErrorMessage();
    }

    private function formatFieldErrorMessages(string $fieldName): void
    {
        $this->errorMessageList[$fieldName] = implode("\n", $this->errorMessageList[$fieldName]);
    }

    private function generateFinalAggregationResult(): array
    {
        return array_merge(
            ['success' => $this->success],
            count($this->errorMessageList)
                ? ['errors' => $this->errorMessageList]
                : []
        );
    }
}