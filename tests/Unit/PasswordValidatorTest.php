<?php

declare(strict_types=1);

namespace Exercise3\Tests\Unit;

require_once 'src/rules/PasswordRuleset.php';
require_once 'src/rules/RuleApplicationSimpleAggregator.php';
require_once 'src/Validator.php';

use Exercise3\Rules\RuleApplicationSimpleAggregator;
use Exercise3\Rules\CharacterLengthAtLeastNRule;
use Exercise3\Rules\ContainsAtLeastMNumbersRule;
use Exercise3\Rules\ContainsAtLeastNCapitalLetterRule;
use Exercise3\Rules\ContainsAtLeastNSpecialCharacterRule;
use Exercise3\Rules\PasswordRuleset;
use Exercise3\Validator;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    public Validator $validator;
    public static array $passwordRuleset;

    public function setUp(): void
    {
        $this->validator = new Validator(new RuleApplicationSimpleAggregator());
    }

    public static function customStaticSetup(): void
    {
        if (!isset(static::$passwordRuleset)) {
            static::$passwordRuleset = (new PasswordRuleset('Password'))->getRules();
        }
    }

    /**
     * @dataProvider shouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputsDataProvider
     */
    public function testShouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputs(array $testcase, array $errors): void
    {
        $result = $this->validator->validate($testcase);

        $this->assertSame(['success' => false, 'errors' => $errors], $result);
    }

    /**
     * @dataProvider shouldPassGivenCorrectInputPassword
     */
    public function testShouldPassGivenCorrectInputPassword(array $testcase): void
    {
        $result = $this->validator->validate($testcase);

        $this->assertSame(['success' => true], $result);
    }

    public static function shouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputsDataProvider(): array
    {
        static::customStaticSetup();

        return [
            [
                ['Password' => ['value' => '', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => '1', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'acd', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'A', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => '52', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => ')', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters"],
            ],
            [
                ['Password' => ['value' => 'Bacd', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'a1a5', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'abcD3ef', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'abc3efabc', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'B_c?', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"],
            ],
            [
                ['Password' => ['value' => 'ab|3efabc', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 2 numbers\nPassword must contain at least 1 capital letters"],
            ],
            [
                ['Password' => ['value' => 'a7Bc3', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'AB34Z67', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'abcAefgh', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'abcdBfg1', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'abcdefg1H', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'abcHefghijK2', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 2 numbers\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'abcdefg15', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 1 capital letters\nPassword must contain at least 1 special characters"],
            ],
            [
                ['Password' => ['value' => 'a7Bc3\'', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must be at least 8 characters long"],
            ],
            [
                ['Password' => ['value' => '!bcdefg1H', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 2 numbers"],
            ],
            [
                ['Password' => ['value' => 'ab+ef7hijd2', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 1 capital letters"],
            ],
            [
                ['Password' => ['value' => 'ab6ef7_ijd2', 'rules' => static::$passwordRuleset]],
                ['Password' => "Password must contain at least 1 capital letters"],
            ],
            [
                ['Password' => ['value' => '1234567A', 'rules' => static::$passwordRuleset]],
                ['Password' => 'Password must contain at least 1 special characters'],
            ],
            [
                ['Password' => ['value' => 'ab2c2fAh24gd', 'rules' => static::$passwordRuleset]],
                ['Password' => 'Password must contain at least 1 special characters'],
            ],
            [
                ['Firstname' => ['value' => 'ab', 'rules' => [new CharacterLengthAtLeastNRule('Firstname', 3)]]],
                ['Firstname' => 'Firstname must be at least 3 characters long'],
            ],
            [
                ['Firstname' => ['value' => 'ab', 'rules' => [new CharacterLengthAtLeastNRule('Firstname', 3)]]],
                ['Firstname' => 'Firstname must be at least 3 characters long'],
            ],
            [
                [
                    'Password' => ['value' => 'abcdef', 'rules' => static::$passwordRuleset],
                    'password_confirm' => ['value' => 'abcdef', 'rules' => [
                        new CharacterLengthAtLeastNRule('password_confirm', 8),
                        new ContainsAtLeastMNumbersRule('password_confirm', 2),
                        new ContainsAtLeastNCapitalLetterRule('password_confirm', 1),
                        new ContainsAtLeastNSpecialCharacterRule('password_confirm', 1),
                    ]],
                ],
                [
                    'Password' => "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least 1 capital letters\nPassword must contain at least 1 special characters",
                    'password_confirm' => "password_confirm must be at least 8 characters long\npassword_confirm must contain at least 2 numbers\npassword_confirm must contain at least 1 capital letters\npassword_confirm must contain at least 1 special characters"
                ],
            ],
        ];
    }

    public static function shouldPassGivenCorrectInputPassword(): array
    {
        static::customStaticSetup();

        return [
            [
                ['Password' => ['value' => '123456+A', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Password' => ['value' => '1A3?5678', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Password' => ['value' => '<33DEFGH', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Password' => ['value' => 'bcdE4g4\\', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Password' => ['value' => '22dfdfA?', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Password' => ['value' => 'ab2c2fAh__4gd', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Password' => ['value' => 'abcdE?Ahij57lm', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Firstname' => ['value' => 'Farzin', 'rules' => [new CharacterLengthAtLeastNRule('Firstname', 3)]]],
            ],
            [
                ['Username' => ['value' => 'Spaceman#!', 'rules' => [new ContainsAtLeastNSpecialCharacterRule('Username', 2)]]],
            ],
            [
                [
                    'StrongPassword' => [
                        'value' => 'F@rZ1nSp@c3man!994',
                        'rules' => [
                            new ContainsAtLeastNSpecialCharacterRule('StrongPassword', 3),
                            new ContainsAtLeastMNumbersRule('StrongPassword', 3),
                            new ContainsAtLeastNCapitalLetterRule('StrongPassword', 2),
                        ]
                    ]
                ],
            ],
        ];
    }
}