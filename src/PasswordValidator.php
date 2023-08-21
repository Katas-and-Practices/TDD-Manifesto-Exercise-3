<?php

namespace Exercise3;

require_once 'src/rules/Rule.php';
require_once 'src/rules/RuleResult.php';
require_once 'src/rules/CharacterLengthAtLeastEightRule.php';
require_once 'src/rules/ContainsAtLeastTwoNumbersRule.php';

use Exercise3\Rules\CharacterLengthAtLeastEightRule;
use Exercise3\Rules\ContainsAtLeastTwoNumbersRule;
use Exercise3\Rules\Rule;
use Exercise3\Rules\RuleResult;

class PasswordValidator
{
    private array $ruleset = [
        CharacterLengthAtLeastEightRule::class,
        ContainsAtLeastTwoNumbersRule::class,
    ];

    public function validate(string $inputPassword)
    {
        return $this->applyRules($inputPassword);
    }

    private function applyRules(string $input): array
    {
        $success = true;
        $errorMessage = '';

        /** @var Rule $rule */
        foreach ($this->ruleset as $rule) {
            /** @var RuleResult $result */
            $result = (new $rule())->apply($input);

            $success = $success && $result->getSuccess();
            $newErrorMessage = $result->getErrorMessage();
            $errorMessage .= ($newErrorMessage && $errorMessage ? "\n" : '') . $result->getErrorMessage();
        }

        return array_merge(['success' => $success], $errorMessage ? ['error-message' => $errorMessage] : []);
    }
}