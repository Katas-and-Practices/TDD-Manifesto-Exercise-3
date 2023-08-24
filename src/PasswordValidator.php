<?php

namespace Exercise3;

require_once 'Validator.php';
require_once 'src/rules/CharacterLengthAtLeastNRule.php';
require_once 'src/rules/ContainsAtLeastMNumbersRule.php';
require_once 'src/rules/ContainsAtLeastNCapitalLetterRule.php';
require_once 'src/rules/ContainsAtLeastNSpecialCharacterRule.php';

use Exercise3\Rules\CharacterLengthAtLeastNRule;
use Exercise3\Rules\ContainsAtLeastNCapitalLetterRule;
use Exercise3\Rules\ContainsAtLeastNSpecialCharacterRule;
use Exercise3\Rules\ContainsAtLeastMNumbersRule;

class PasswordValidator implements Validator
{
    private array $ruleset = [
        ['class' => CharacterLengthAtLeastNRule::class, 'args' => [8]],
        ['class' => ContainsAtLeastMNumbersRule::class, 'args' => [2]],
        ['class' => ContainsAtLeastNCapitalLetterRule::class, 'args' => [1]],
        ['class' => ContainsAtLeastNSpecialCharacterRule::class, 'args' => [1]],
    ];

    private array $rulesetObjects;

    public function __construct()
    {
        foreach ($this->ruleset as $rule) {
            $this->rulesetObjects[] = new $rule['class'](...$rule['args']);
        }
    }

    public function getRules(): array
    {
        return $this->rulesetObjects;
    }
}