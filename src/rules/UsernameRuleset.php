<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'Ruleset.php';
require_once 'ContainsNoSpecialCharacterRule.php';

class UsernameRuleset extends Ruleset
{
    protected array $ruleset = [
        ['class' => CharacterLengthAtLeastNRule::class, 'args' => [4]],
        ['class' => ContainsNoSpecialCharacterRule::class, 'args' => []],
    ];
}