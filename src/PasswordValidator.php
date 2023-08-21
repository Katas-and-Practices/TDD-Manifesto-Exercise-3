<?php

namespace Exercise3;

require_once 'src/rules/Rule.php';
require_once 'src/rules/RuleResult.php';
require_once 'src/rules/CharacterLengthAtLeastEightRule.php';
require_once 'src/rules/ContainsAtLeastTwoNumbersRule.php';
require_once 'src/rules/ContainsAtLeastOneCapitalLetterRule.php';

use Exercise3\Rules\CharacterLengthAtLeastEightRule;
use Exercise3\Rules\ContainsAtLeastOneCapitalLetterRule;
use Exercise3\Rules\ContainsAtLeastTwoNumbersRule;
use Exercise3\Rules\Rule;
use Exercise3\Rules\RuleResult;

class PasswordValidator
{
    private array $ruleset = [
        CharacterLengthAtLeastEightRule::class,
        ContainsAtLeastTwoNumbersRule::class,
        ContainsAtLeastOneCapitalLetterRule::class,
    ];

    public function validate(string $inputPassword)
    {
        return $this->applyRules($inputPassword);
    }

    private function applyRules(string $input): array
    {
        $rawResults = [];

        /** @var Rule $rule */
        foreach ($this->ruleset as $rule) {
            $rawResults[] = (new $rule())->apply($input);
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