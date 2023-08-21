<?php

namespace Exercise3\Tests\Unit;

require_once 'src/PasswordValidator.php';

use Exercise3\PasswordValidator;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
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
            ['', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one capital letter"],
            ['1', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one capital letter"],
            ['acd', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers\nPassword must contain at least one capital letter"],
            ['A', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"],
            ['52', "Password must be at least 8 characters long\nPassword must contain at least one capital letter"],
            ['Bacd', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"],
            ['a1a5', "Password must be at least 8 characters long\nPassword must contain at least one capital letter"],
            ['abcD3ef', "Password must be at least 8 characters long\nPassword must contain at least 2 numbers"],
            ['abc3efabc', "Password must contain at least 2 numbers\nPassword must contain at least one capital letter"],
            ['a7Bc3', 'Password must be at least 8 characters long'],
            ['AB34Z67', 'Password must be at least 8 characters long'],
            ['abcAefgh', 'Password must contain at least 2 numbers'],
            ['abcdBfg1', 'Password must contain at least 2 numbers'],
            ['abcdefg1H', 'Password must contain at least 2 numbers'],
            ['abcHefghijK2', 'Password must contain at least 2 numbers'],
            ['abcdefg15', 'Password must contain at least one capital letter'],
            ['ab6ef7hijd2', 'Password must contain at least one capital letter'],
        ];
    }

    public static function shouldPassGivenCorrectInputPassword(): array
    {
        return [
            ['1234567A'],
            ['1A345678'],
            ['23CDEFGH'],
            ['abcdE4g4'],
            ['22dfdfAh'],
            ['ab2c2fAh24gd'],
            ['abcdEfAhij57lm'],
        ];
    }
}