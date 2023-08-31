<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'Ruleset.php';
require_once 'CharacterLengthAtLeastNRule.php';
require_once 'ContainsAtLeastMNumbersRule.php';
require_once 'ContainsAtLeastNCapitalLetterRule.php';
require_once 'ContainsAtLeastNSpecialCharacterRule.php';

class PasswordRuleset extends Ruleset
{
    protected array $ruleset = [
        ['class' => CharacterLengthAtLeastNRule::class, 'args' => [8]],
        ['class' => ContainsAtLeastMNumbersRule::class, 'args' => [2]],
        ['class' => ContainsAtLeastNCapitalLetterRule::class, 'args' => [1]],
        ['class' => ContainsAtLeastNSpecialCharacterRule::class, 'args' => [1]],
    ];
}