<?php

namespace Exercise3\Rules;

require_once 'Ruleset.php';
require_once 'CharacterLengthAtLeastNRule.php';
require_once 'ContainsAtLeastMNumbersRule.php';
require_once 'ContainsAtLeastNCapitalLetterRule.php';
require_once 'ContainsAtLeastNSpecialCharacterRule.php';

class PasswordRuleset implements Ruleset
{
    private array $ruleset = [
        ['class' => CharacterLengthAtLeastNRule::class, 'args' => [8]],
        ['class' => ContainsAtLeastMNumbersRule::class, 'args' => [2]],
        ['class' => ContainsAtLeastNCapitalLetterRule::class, 'args' => [1]],
        ['class' => ContainsAtLeastNSpecialCharacterRule::class, 'args' => [1]],
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