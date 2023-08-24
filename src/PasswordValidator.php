<?php

namespace Exercise3;

require_once 'Validator.php';
require_once 'src/rules/CharacterLengthAtLeastEightRule.php';
require_once 'src/rules/ContainsAtLeastTwoNumbersRule.php';
require_once 'src/rules/ContainsAtLeastOneCapitalLetterRule.php';
require_once 'src/rules/ContainsAtLeastOneSpecialCharacterRule.php';

use Exercise3\Rules\CharacterLengthAtLeastEightRule;
use Exercise3\Rules\ContainsAtLeastOneCapitalLetterRule;
use Exercise3\Rules\ContainsAtLeastOneSpecialCharacterRule;
use Exercise3\Rules\ContainsAtLeastTwoNumbersRule;

class PasswordValidator implements Validator
{
    private array $ruleset = [
        CharacterLengthAtLeastEightRule::class,
        ContainsAtLeastTwoNumbersRule::class,
        ContainsAtLeastOneCapitalLetterRule::class,
        ContainsAtLeastOneSpecialCharacterRule::class,
    ];

    public function getRules(): array
    {
        return $this->ruleset;
    }
}