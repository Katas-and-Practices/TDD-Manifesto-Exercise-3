<?php

declare(strict_types=1);

namespace Exercise3\Rules;

interface Ruleset
{
    public function getRules(): array;
}