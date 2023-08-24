<?php

namespace Exercise3\Rules;

interface RuleApplicationAggregator
{
    public function aggregate(array $ruleset): array|string;
}