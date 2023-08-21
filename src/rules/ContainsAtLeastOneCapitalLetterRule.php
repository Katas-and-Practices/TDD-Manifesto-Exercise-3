<?php

namespace Exercise3\Rules;

require_once 'Rule.php';
require_once 'RuleResult.php';

class ContainsAtLeastOneCapitalLetterRule implements Rule
{
    public function apply(string $input): RuleResult
    {
        $success = preg_match('/.*[A-Z]{1}.*/', $input);
        $errorMessage = $success ? '' : 'Password must contain at least one capital letter';

        return new RuleResult($success, $errorMessage);
    }
}