<?php

namespace Exercise3\Rules;

require_once 'Rule.php';
require_once 'RuleResult.php';

class ContainsAtLeastOneSpecialCharacterRule implements Rule
{
    public function apply(string $input): RuleResult
    {
        $success = preg_match('/.*[,<.>\/?:;\'\"|\\\{\]}~!@#$%^&*()\-_+=].*/', $input);
        $errorMessage = $success ? '' : 'Password must contain at least one special character';

        return new RuleResult($success, $errorMessage);
    }
}