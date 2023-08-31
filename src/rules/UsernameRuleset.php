<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RulesetBase.php';
require_once 'ContainsNoSpecialCharacterRule.php';

class UsernameRuleset extends RulesetBase
{
    protected array $ruleset = [
        ['class' => CharacterLengthAtLeastNRule::class, 'args' => [4]],
        ['class' => ContainsNoSpecialCharacterRule::class, 'args' => []],
    ];
}