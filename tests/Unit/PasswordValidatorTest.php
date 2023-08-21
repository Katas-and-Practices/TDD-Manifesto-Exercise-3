<?php

namespace Exercise3\Tests\Unit;

require_once 'src/PasswordValidator.php';

use Exercise3\PasswordValidator;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    protected const ERROR_MIN_8_CHAR_LENGTH = 'Password must be at least 8 characters long';
    protected const ERROR_MIN_2_NUMBER = 'Password must contain at least 2 numbers';
    protected const ERROR_MIN_1_CAPITAL = 'Password must contain at least one capital letter';
    protected const ERROR_MIN_1_SPECIAL = 'Password must contain at least one special character';

    public PasswordValidator $passwordValidator;

    public function setUp(): void
    {
        $this->passwordValidator = new PasswordValidator();
    }

    /**
     * @dataProvider shouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputsDataProvider
     */
    public function testShouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputs(string $testcase, string $errorMessage): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => false, 'error-message' => $errorMessage], $result);
    }

    /**
     * @dataProvider shouldPassGivenCorrectInputPassword
     */
    public function testShouldPassGivenCorrectInputPassword(string $testcase): void
    {
        $result = $this->passwordValidator->validate($testcase);

        $this->assertSame(['success' => true], $result);
    }

    public static function shouldReturnMultipleErrorMessagesGivenVariousCombinationsOfInvalidInputsDataProvider(): array
    {
        return [
            ['', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['1', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['acd', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['A', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['52', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            [')', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL],
            ['Bacd', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['a1a5', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['abcD3ef', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['abc3efabc', self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['B_c?', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_2_NUMBER],
            ['ab|3efabc', self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_CAPITAL],
            ['a7Bc3', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['AB34Z67', self::ERROR_MIN_8_CHAR_LENGTH . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['abcAefgh', self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['abcdBfg1', self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['abcdefg1H', self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['abcHefghijK2', self::ERROR_MIN_2_NUMBER . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['abcdefg15', self::ERROR_MIN_1_CAPITAL . "\n" . self::ERROR_MIN_1_SPECIAL],
            ['a7Bc3\'', self::ERROR_MIN_8_CHAR_LENGTH],
            ['!bcdefg1H', self::ERROR_MIN_2_NUMBER],
            ['ab+ef7hijd2', self::ERROR_MIN_1_CAPITAL],
            ['ab6ef7_ijd2', self::ERROR_MIN_1_CAPITAL],
            ['1234567A', self::ERROR_MIN_1_SPECIAL],
            ['ab2c2fAh24gd', self::ERROR_MIN_1_SPECIAL],
        ];
    }

    public static function shouldPassGivenCorrectInputPassword(): array
    {
        return [
            ['123456+A'],
            ['1A3?5678'],
            ['<33DEFGH'],
            ['bcdE4g4\\'],
            ['22dfdfA?'],
            ['ab2c2fAh__4gd'],
            ['abcdE?Ahij57lm'],
        ];
    }
}