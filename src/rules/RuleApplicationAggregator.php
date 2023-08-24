<?php

declare(strict_types=1);

namespace Exercise3\Rules;

interface RuleApplicationAggregator
{
    public function aggregate(array $ruleset): array|string;
}