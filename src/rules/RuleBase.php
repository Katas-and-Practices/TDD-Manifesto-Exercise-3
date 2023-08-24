<?php

declare(strict_types=1);

namespace Exercise3\Rules;

require_once 'RuleBase.php';

abstract class RuleBase
{
    public abstract function apply(string $input): RuleResult;
}