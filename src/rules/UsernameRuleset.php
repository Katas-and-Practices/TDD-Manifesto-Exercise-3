<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'ContainsNoSpecialCharacterRule.php';

class UsernameRuleset implements Ruleset
{
    private array $ruleset = [
        ['class' => CharacterLengthAtLeastNRule::class, 'args' => [4]],
        ['class' => ContainsNoSpecialCharacterRule::class, 'args' => []],
    ];

    private array $rulesetObjects;

    public function __construct(string $fieldName)
    {
        foreach ($this->ruleset as $rule) {
            $this->rulesetObjects[] = new $rule['class']($fieldName, ...$rule['args']);
        }
    }

    public function getRules(): array
    {
        return $this->rulesetObjects;
    }
}