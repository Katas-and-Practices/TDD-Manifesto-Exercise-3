<?php

declare(strict_types=1);

namespace Exercise3\Tests\Unit;

require_once 'src/rules/PasswordRuleset.php';
require_once 'src/Validator.php';

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

    protected const ERROR_MIN_8_CHAR_LENGTH = 'Password must be at least 8 characters long';
    protected const ERROR_MIN_2_NUMBER = 'Password must contain at least 2 numbers';
    protected const ERROR_MIN_1_CAPITAL = 'Password must contain at least 1 capital letters';
    protected const ERROR_MIN_1_SPECIAL = 'Password must contain at least 1 special characters';

    public function setUp(): void
    {
        $this->validator = new Validator();
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
                ['Password' => self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ],
            [
                ['Password' => ['value' => '1', 'rules' => static::$passwordRuleset]],
                ['Password' => self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ],
            [
                ['Password' => ['value' => 'acd', 'rules' => static::$passwordRuleset]],
                ['Password' => self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ],
            [
                ['Password' => ['value' => 'a7Bc3\'', 'rules' => static::$passwordRuleset]],
                ['Password' => self::ERROR_MIN_8_CHAR_LENGTH],
            ],
            [
                ['Password' => ['value' => '!bcdefg1H', 'rules' => static::$passwordRuleset]],
                ['Password' => self::ERROR_MIN_2_NUMBER],
            ],
            [
                ['Password' => ['value' => 'ab+ef7hijd2', 'rules' => static::$passwordRuleset]],
                ['Password' => self::ERROR_MIN_1_CAPITAL],
            ],
            [
                ['Password' => ['value' => '1234567A', 'rules' => static::$passwordRuleset]],
                ['Password' => self::ERROR_MIN_1_SPECIAL],
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
                    'Password' => self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL,
                    'password_confirm' => "password_confirm must be at least 8 characters long\n" .
                        "password_confirm must contain at least 2 numbers\n" .
                        "password_confirm must contain at least 1 capital letters\n" .
                        "password_confirm must contain at least 1 special characters"
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
                ['Password' => ['value' => '\\bcdE4g4', 'rules' => static::$passwordRuleset]],
            ],
            [
                ['Password' => ['value' => 'ab2c2fAh__4gd', 'rules' => static::$passwordRuleset]],
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