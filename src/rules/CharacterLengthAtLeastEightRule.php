<?php

namespace Exercise3\Rules;

require_once 'Rule.php';
require_once 'RuleResult.php';

class CharacterLengthAtLeastEightRule implements Rule
{
    public function apply(string $input): RuleResult
    {
        $success = strlen($input) >= 8;
        $errorMessage = $success ? '' : 'Password must be at least 8 characters long';

        return new RuleResult($success, $errorMessage);
    }
}