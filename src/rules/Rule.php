<?php

namespace Exercise3\Rules;

require_once 'RuleResult.php';

interface Rule
{
    public function apply(string $input): RuleResult;
}