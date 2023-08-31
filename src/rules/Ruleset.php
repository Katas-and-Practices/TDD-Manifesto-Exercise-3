<?php

declare(strict_types=1);

namespace Exercise3\Rules;

abstract class Ruleset
{
    protected array $ruleset = [];
    protected array $rulesetObjects = [];

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