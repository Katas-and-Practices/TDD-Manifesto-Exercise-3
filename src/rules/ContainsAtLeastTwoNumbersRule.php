<?php

namespace Exercise3\Rules;

require_once 'Rule.php';
require_once 'RuleResult.php';

class ContainsAtLeastTwoNumbersRule implements Rule
{
    public function apply(string $input): RuleResult
    {
        $success = preg_match('/.*[0-9].*[0-9].*/', $input);
        $errorMessage = $success ? '' : 'Password must contain at least 2 numbers';

        return new RuleResult($success, $errorMessage);
    }
}