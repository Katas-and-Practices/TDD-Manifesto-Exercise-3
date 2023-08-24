<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleApplicationAggregator.php';

class RuleApplicationSimpleAggregator implements RuleApplicationAggregator
{
    private bool $success = true;
    private $errorMessageList = [];

    public function aggregate(array $rawResults): array
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